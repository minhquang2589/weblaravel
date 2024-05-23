<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orders;
use App\Models\Payment;
use App\Models\Customers;
use Illuminate\Support\Facades\Redirect;
use App\Models\color;
use App\Models\Section_02;
use App\Models\Product;
use App\Models\ordernumber;
use App\Models\size;
use App\Models\User;
use App\Models\product_colors;
use App\Models\product_sizes;
use Illuminate\Support\Str;
use App\Models\product_variants;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Validator;
use App\Models\OrderItems;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;

use App\Models\featured_sections;


class SectionController extends Controller
{
     
   public function error()
   {
      return view('layout.error');
   }
   ///
   public function featuredsession()
   {
      return view('layout.error');
   }
   ///
   public function upload_section(){
      return view('section.upload');
   }
   public function featuredsectionsDelete($id)
   {
      try {
         DB::beginTransaction();
         $featured_sections = featured_sections::find($id);
         if (!$featured_sections) {
            return redirect()->back()->with('error', 'featured_sections not found.');
         }
         $featured_sections->delete();
         DB::commit();
         return redirect()->back()->with('success', 'featured_sections deleted successfully.');
      } catch (\Exception $e) {
         DB::rollBack();
         return redirect()->back()->with('error', 'Failed to delete featured_sections.');
      }
   }
   ////
   public function featuredsectionsEdit($id)
   {
      $featuredsectionsEdit = featured_sections::findOrFail($id);
      return view('featuredsection.featuredsection-update', ['featuredsectionsEdit' => $featuredsectionsEdit]);
   }
   //
   public function featuredsectionsUpdate(Request $request)
   {
      $data = $request->all();
      $status = isset($data['status']) && $data['status'] === 'on' ? '1' : '0';
      $featuredSection = featured_sections::find($data['id']);
      if ($request->hasFile('imgcontent')) {
         $image = $request->file('imgcontent');
         $imageName = time() . '.' . $image->getClientOriginalExtension();
         $image->move(public_path('images'), $imageName);
         $featuredSection->image = $imageName;
      }
      $featuredSection->name = $data['content'];
      $featuredSection->status = $status;
      $featuredSection->save();
      return redirect()->back()->with('success', 'Update featured successfully!');
   }
   //
   public function section_02()
   {
      $section = Section_02::all();
      return view('section.section_02_edit', [
         'section_02' => $section,
      ]);
   }
   ///
   public function section_02Update($section_id)
   {
      $section = Section_02::find($section_id);
      return view('section.section_02_update', [
         'section_update' => $section
      ]);
   }
   ///
   public function section_02Delete(Request $request)
   {
      try {
         DB::beginTransaction();
         $section = Section_02::find($request->input('sectionID'));
         if (!$section) {
            return redirect()->back()->with('error', 'Section not found.');
         }

         $section->delete();

         DB::commit();

         return redirect()->back()->with('success', 'Section deleted successfully.');
      } catch (\Exception $e) {
         DB::rollBack();
         return redirect()->back()->with('error', 'Failed to delete section.');
      }
   }

   //
   public function section_02Edit(Request $request)
   {
      $validator = Validator::make($request->all(), [
         'title' => 'required|string|max:100',
         'description' => 'required|string|max:300',
         'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
      ]);

      if ($validator->fails()) {
         return redirect()->back()->withErrors($validator)->withInput();
      }
      $data = $request->all();
      $status = isset($data['status']) && $data['status'] === 'on' ? '1' : '0';
      $data = $request->all();
      if ($request->hasFile('image')) {
         $image = $request->file('image');
         $imageName = time() . '.' . $image->getClientOriginalExtension();
         $image->move(public_path('images'), $imageName);
      }
      $section = new Section_02();
      $section->title = $data['title'];
      $section->description = $data['description'];
      $section->image = $imageName;
      $section->status = $status;
      $section->save();
      return redirect()->back()->with('success', 'Upload section successfully!');
   }
   ///
   public function sectionUpdate(Request $request )
   {
      // dd($request);
      $section = Section_02::find($request->input('section_id'));
      if (!$section) {
         return redirect()->back()->with('error', 'Section not found.');
      }
      $data = $request->all();
      $status = $request->has('status') ? '1' : '0';
      if ($request->hasFile('image')) {
         $image = $request->file('image');
         $imageName = time() . '.' . $image->getClientOriginalExtension();
         $image->move(public_path('images'), $imageName);
         $section->image = $imageName;
      }
      $section->update([
         'title' => $data['title'],
         'description' => $data['description'],
         'status' => $status,
      ]);
      return redirect()->back()->with('success', 'Section updated successfully!');
   }
}
