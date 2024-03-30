<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SupplierController extends Controller
{
    /**
     * Show suppliers list
     *
     * @return \Illuminate\Http\Response
     */
    public function all() {

        $suppliers = Supplier::paginate(10);

        return view('admin.frontend.suppliers.list', compact('suppliers'));
    }
    /**
     * Show form for creating a new supplier
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.frontend.suppliers.add');
    }

    /**
     * Store a new created supplier in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        
        $validator = $this->validateAddForm($request);
        $this->doStore($validator);

            return redirect()->route('admin.suppliers.all')->with('simpleSuccessAlert', 'Supplier added successfully');
    }
    /**
     * Show form for editing the specified supplier.
     *
     * @param  \App\Models\Supplier $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {
        return view('admin.frontend.suppliers.edit', compact('supplier'));
    }
    /**
     * Update specified supplier in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Supplier $supplier
     * @return \Illuminate\Http\Response
     */

     public function update(Supplier $supplier, Request $request){
        $validator = $this->validateUpdateForm($request);

        $this->doUpdate($product , $validator);

        try {
            // Validate form data
            $validatedData = $request->validate([
                'supplier_name' => 'required|string|max:255',
                'contact_number' => 'required|email|unique:users,email',
                'address' => 'required|string|min:255',
                'image_path' => 'nullable|string|max:200',
                'prod_id' => 'disabled|numeric',
            ]);

            // Create supplier
            $supplier = new Supplier();
            $supplier->supplier_name = $validatedData['supplier_name'];
            $supplier->contact_number = $validatedData['contact_num'];
            $supplier->address = $validatedData['address'];
            $supplier->image_path = $validatedData['image_path'];
            $supplier->prod_id = $validatedData['prod_id'];
            $supplier->save();

            return redirect()->route('admin.suppliers.all')->with('simpleSuccessAlert', 'Supplier updated successfully');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['failed_update' => 'Failed to update supplier.']);
        }    }
    /**
     * Remove specified user from storage.
     *
     * @param  \App\Models\Supplier $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier){
        File::delete(public_path("\images\users\\$supplier->image_path"));

        $supplier->delete();

        return back()->with('simpleSuccessAlert' , 'Supplier removed successfully');
    }
    
}
