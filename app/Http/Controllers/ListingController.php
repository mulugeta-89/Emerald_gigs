<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    // show all listing
    public function index(){
        return view("listings.index", [
            "listings" => Listing::latest()->filter(request(["tag", "search"]))->paginate(6)
        ]);
    }
    //show single listing
    public function show(Listing $listing){
        return view("listings.show", [
            "listing" => $listing
        ]);
    }
    // to show the create form
    public function create(){
        return view("listings.create");
    }
    // to store the filled form of listing
    public function store(Request $request){
        $formFields = $request->validate([
            "title" => "required",
            "company" => ["required", Rule::unique("listings", "company")],
            "location" => "required",
            "website" => "required",
            "email" => ["required", "email"],
            "tags" => "required",
            "description" => "required"
        ]);
        if($request->hasFile("logo")){
            $formFields["logo"] = $request->file("logo")->store("logos", "public");
        }
        $formFields["user_id"] = auth()->id();
        Listing::create($formFields);
        return redirect("/")->with("message", "listing created successfully!");
    }

    public function edit(Listing $listing){
        return view("listings.edit", ["listing" => $listing]);
    }
    public function update(Request $request, Listing $listing){
        if($listing->user_id != auth()->id()){
            abort(403, "Unauthorized action");
        }
        $formFields = $request->validate([
            "title" => "required",
            "company" => "required",
            "location" => "required",
            "website" => "required",
            "email" => ["required", "email"],
            "tags" => "required",
            "description" => "required"
        ]);
        if($request->hasFile("logo")){
            $formFields["logo"] = $request->file("logo")->store("logos", "public");
        }
        $listing->update($formFields);
        return back()->with("message", "listing updated successfully!");
    }
    public function destroy(Listing $listing){
        if($listing->user_id != auth()->id()){
            abort(403, "Unauthorized action");
        }
        $listing->delete();
        return redirect("/")->with("message", "Listing deleted succesfully!");
    }
    public function manage(){
        return view("listings.manage", ["listings" => auth()->user()->listing()->get()]);
    }
}