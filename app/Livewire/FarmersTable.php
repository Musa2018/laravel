<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Farmer;
use App\Models\Governorate;
use App\Models\Locality;
use App\Models\Gender;
use App\Models\IdentityType;
use Illuminate\Support\Facades\Auth;

class FarmersTable extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'id';
    public $sortDirection = 'desc';
    public $perPage = 10;

    // حقول CRUD
    public $farmerId;
    public $name_en, $name_ar, $birthdate, $phone, $identity, $identity_type_id;
    public $address, $gender_id, $governorate_id, $locality_id;

    public $governorates = [];
    public $localities = [];
    public $genders = [];
    public $identityTypes = [];

    public $isModalOpen = false;

    protected $paginationTheme = 'tailwind';

    // إعادة تعيين الصفحة عند البحث
    public function updatingSearch()
    {
        $this->resetPage();
    }

    // فرز الأعمدة
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    // فتح Modal لإنشاء أو تعديل
    public function openModal($id = null)
    {
        $this->resetInputFields();
        $this->loadSelections();

        if($id){
            $farmer = Farmer::findOrFail($id);
            $this->farmerId = $id;
            $this->name_en = $farmer->name_en;
            $this->name_ar = $farmer->name_ar;
            $this->birthdate = $farmer->birthdate;
            $this->phone = $farmer->phone;
            $this->identity = $farmer->identity;
            $this->identity_type_id = $farmer->identity_type_id;
            $this->address = $farmer->address;
            $this->gender_id = $farmer->gender_id;
            $this->governorate_id = $farmer->governorate_id;
            $this->updatedGovernorateId($farmer->governorate_id); // تحديث القرى
            $this->locality_id = $farmer->locality_id;

        }

        $this->isModalOpen = true;
    }

    // إغلاق Modal
    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    // إعادة تعيين الحقول
    private function resetInputFields()
    {
        $this->farmerId = null;
        $this->name_en = '';
        $this->name_ar = '';
        $this->birthdate = '';
        $this->phone = '';
        $this->identity = '';
        $this->identity_type_id = '';
        $this->address = '';
        $this->gender_id = '';
        $this->governorate_id = '';
        $this->locality_id = '';
        $this->localities = [];
    }

    // تحميل القوائم المرتبطة
    private function loadSelections()
    {
        $this->governorates = Governorate::all();
        $this->genders = Gender::all();
        $this->identityTypes = IdentityType::all();
    }

    // تحديث القرى عند اختيار المحافظة
    public function updatedGovernorateId($value)
    {
        $this->locality_id = null;
        $this->localities = Locality::where('governorate_id',$this->governorate_id)->get();
    }

    // حفظ البيانات (إنشاء أو تعديل) مع التحقق
    public function save()
    {
        $validatedData = $this->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'birthdate' => 'nullable|date',
            'phone' => 'nullable|string|max:20',
            'identity' => 'required|digits:9|unique:farmers,identity,' . $this->farmerId,
            'identity_type_id' => 'required|exists:identity_types,id',
            'address' => 'nullable|string|max:255',
            'gender_id' => 'required|exists:genders,id',
            'governorate_id' => 'required|exists:governorates,id',
            'locality_id' => 'required|exists:localities,id',

        ]);

        if (!$this->farmerId) {
            // عند الإنشاء، أضف created_by
            $validatedData['created_by'] = Auth::user()->id;
        }

        Farmer::updateOrCreate(['id' => $this->farmerId], $validatedData);

        $this->closeModal();
        session()->flash('message', $this->farmerId ? 'Farmer Updated Successfully.' : 'Farmer Created Successfully.');
    }

    // حذف سجل
    public function delete($id)
    {
        Farmer::findOrFail($id)->delete();
        session()->flash('message', 'Farmer Deleted Successfully.');
    }

    public function render()
    {
        $search = $this->search;
        $farmers = Farmer::with('governorate','locality','gender','identityType')
            ->where(function($query) use ($search) {
                $query->where('name_en', 'like', "%$search%")
                    ->orWhere('name_ar', 'like', "%$search%")
                    ->orWhere('identity', 'like', "%$search%")
                    ->orWhere('phone', 'like', "%$search%");
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->simplePaginate($this->perPage);

        return view('livewire.farmers-table', compact('farmers'));
    }
}
