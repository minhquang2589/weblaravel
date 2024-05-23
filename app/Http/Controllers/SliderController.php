<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\slider;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;



class SliderController extends Controller
{
    //
    public function slider()
    {
        $slider = slider::all();
        // dd($slider);
        if ($slider) {
            return view('slider.slider', ['slider' => $slider]);
        }
    }
    //
    public function sliderEdit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            DB::beginTransaction();
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $fileName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('images'), $fileName);
            } else {
                return redirect()->back()->with('error', 'Please choose an image to upload.');
            }
            $slider = new Slider();
            $slider->name = $request->input('name');
            $slider->image = $fileName;
            $slider->status = $request->input('status') === 'on' ? 1 : 0;
            $slider->description = $request->input('description') ?? null;
            $slider->save();
            DB::commit();
            return redirect()->back()->with('success', 'slider upload successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to upload slider.');
        }
    }
    ///
    public function sliderDelete($id)
    {
        try {
            DB::beginTransaction();
            $slider = slider::find($id);
            if (!$slider) {
                return redirect()->back()->with('error', 'slider not found.');
            }
            $slider->delete();
            DB::commit();
            return redirect()->back()->with('success', 'slider deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to delete slider.');
        }
    }
    //
    public function sliderUpdate($id)
    {
        $sliderUpdate = Slider::findOrFail($id);
        return view('slider.update', ['sliderUpdate' => $sliderUpdate]);
    }
    ///
    public function sliderUpload(){
        return view ('slider.upload');
    }
    public function editView(Request $request)
    {
        $data = $request->all();
        // dd($data);
        $status = isset($data['status']) && $data['status'] === 'on' ? '1' : '0';
        $editViewSlider = Slider::find($data['id']);
        if ($request->hasFile('imgcontent')) {
            $image = $request->file('imgcontent');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $editViewSlider->image = $imageName;
        }
        $editViewSlider->name = $data['content'];
        $editViewSlider->status = $status;
        $editViewSlider->save();
        return redirect()->back()->with('success', 'Update Slider successfully!');
    }
}
