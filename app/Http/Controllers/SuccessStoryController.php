<?php

namespace App\Http\Controllers;

use App\Models\SuccessStory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class SuccessStoryController extends Controller
{

    private $name_rules = [];
    private $name_message = [];
    public function __construct()
    {
        $this->name_rules = [
            'name' => ['required', 'min:5', 'max:50'],
        ];
        $this->name_message = [
            'name.required' => translate('Name is required'),
            'name.max' => translate('Name must not exceed 50 characters'),
            'name.min' => translate('Name must be at least 5 characters'),
        ];
    }
    public function index(Request $request)
    {
        $search = null;
        $successStories = SuccessStory::query();
        if ($request->has('search')) {
            $search = $request->search;
            $successStories = $successStories->where('name', 'like', '%' . $search . '%');
        }
        $successStories = $successStories->orderBy('created_at', 'desc')->paginate(15);
        return view('backend.success_stories.index', compact('successStories', 'search'));
    }
    public function create()
    {
        return view('backend.success_stories.create');
    }


    public function store(Request $request)
    {
        $rules      = $this->name_rules;
        $messages   = $this->name_message;
        $validator  = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            flash(translate('Sorry! Something went wrong'))->error();
            return Redirect::back()->withErrors($validator);
        }
        $successStoy = new  SuccessStory();
        $successStoy->name = $request->name;
        $successStoy->description = $request->description;
        $successStoy->image = $request->image;
        $successStoy->save();

        if ($successStoy) {
            flash(translate('Success Story been created successfully!'))->success();
            return redirect()->route('success-stories.index');
        } else {
            flash(translate('Failed to add'))->error();
            return redirect()->route('success-stories.index');
        }
    }


    public function show(string $id) {}


    public function edit(string $id)
    {
        $successStory = SuccessStory::findOrFail($id);
        return view('backend.success_stories.edit', compact('successStory'));
    }


    public function update(Request $request, string $id)
    {

        $rules      = $this->name_rules;
        $messages   = $this->name_message;
        $validator  = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            flash(translate('Sorry! Something went wrong'))->error();
            return Redirect::back()->withErrors($validator);
        }
        $successStoy = SuccessStory::find($id);
        $successStoy->name = $request->name;
        $successStoy->description = $request->description;
        $successStoy->image = $request->image;
        $successStoy->save();

        if ($successStoy) {
            flash(translate('Success Story been created successfully!'))->success();
            return redirect()->route('success-stories.index');
        } else {
            flash(translate('Failed to add'))->error();
            return redirect()->route('success-stories.index');
        }
    }


    public function destroy(string $id)
    {
        SuccessStory::where('id', $id)->delete();
        flash(translate('Success Story been created successfully!'))->success();
        return redirect()->route('success-stories.index');
    }
}
