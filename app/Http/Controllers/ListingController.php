<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    


    //display all listing
    public function index(){
        return view('listing.index', [
            'listings' => Listing::latest()->filter(request(['tag','search']))->paginate(3)
        ]);
    }

    

    //create form
    public function create(){
        return view('listing.create');
    }


    //function to save data submit to database
    public function store(Request $request){
        //dd($request->all());
        //dd($request->file('logo'));
        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings','company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required','email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        //check to see if file exist
        if($request->hasFile('logo')){
            $formFields['logo'] = $request->file('logo')->store('logos','public');//public since..
            //name of table         //name of file          //what we want to name filePath
        }

        $formFields['user_id'] = auth()->id();



        Listing::create($formFields);

        //flash message
        //Session::flash('message','Listing Created.');


        return redirect('/')->with('message','Listing Created Successfully.');
    }

    //function to edit Form
    public function edit(Listing $listing){
        //dd($listing->title);
        return view('listing.edit', [
            'listing' => $listing
        ]);
    }

    //function to update data in database
    public function update(Request $request, Listing $listing){
        //dd($request->all());
        //dd($request->file('logo'));
        if($listing->user_id != auth()->id()){
            abort(403, 'Unauthorized action');
        }
        $formFields = $request->validate([
            'title' => 'required',
            'company' => 'required',
            'location' => 'required',
            'website' => 'required',
            'email' => ['required','email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        //check to see if file exist
        if($request->hasFile('logo')){
            $formFields['logo'] = $request->file('logo')->store('logos','public');//public since..
            //name of table         //name of file          //what we want to name filePath
        }

        $formFields['user_id'] = auth()->id();


        //
        $listing->update($formFields);

        //flash message
        //Session::flash('message','Listing Created.');


        return back()->with('message','Listing Updated Successfully.');
    }

    //delete listing
    public function destroy(Listing $listing){
        //check if listing matches owner
        if($listing->user_id != auth()->id()){
            abort(403, 'Unauthorized action');//only allow user to delete their own listings
        }
        $listing->delete();
        return redirect('/')->with('message', 'Listing Deleted Successfully.');
    }

    //manage listing
    public function manage(){
        return view('/listing.manage', ['listings'=> auth()->user()->listings()->get()]);
    }


    //display single listing(always keep at the bottom)
    public function show(Listing $listing){
        return view('listing.show', [
            'listing' => $listing
        ]);
    }
}
