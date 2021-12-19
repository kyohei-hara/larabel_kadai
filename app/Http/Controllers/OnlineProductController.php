<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OnlineProduct;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OnlineProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        // $contacts = DB::table('contact_forms')->select('id', 'your_name', 'title', 'created_at')->paginate(20);

        $query = DB::table('online_product');
        $name = null;
        $maker = null;
        $max = null;
        $min = null;
        if($search !== null){
            $name = $request->input('PRODUCT_NAME');
            $maker = $request->input('MAKER');
            $max = $request->input('max');
            $min = $request->input('min');
            $this->validator($request->all())->validate();
            if($name !== null) {
                $query->where('PRODUCT_NAME','like','%'.$name.'%');
            }
            if($maker !== null) {
                $query->where('MAKER','like','%'.$maker.'%');
            }
            if($max !== null){
                $query->where('UNIT_PRICE','<', $max + 1);
            }
            if($min !== null){
                $query->where('UNIT_PRICE','>',$min - 1);
            }

        }
        $products = $query->select('PRODUCT_CODE', 'CATEGORY_ID', 'PRODUCT_NAME', 'MAKER', 'UNIT_PRICE' , 'MEMO')->where('DELETE_FLG', 0)->paginate(10);
        return view('product.index', compact('products'))->with([
            'PRODUCT_NAME'=>$name,
            'MAKER'=>$maker,
            'min'=>$min,
            'max'=>$max,

        ]);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'min' => ['null_numeric', 'positive'],
            'max' => ['null_numeric', 'positive', 'comparison:min'],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('contact.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $contactForm = new ContactForm;
        // $contactForm->your_name = $request->input('your_name');
        // $contactForm->title = $request->input('title');
        // $contactForm->email = $request->input('email');
        // $contactForm->url = $request->input('url');
        // $contactForm->gender = $request->input('gender');
        // $contactForm->age = $request->input('age');
        // $contactForm->contact = $request->input('contact');

        // // dd($contactForm, $request);
        // // $caution = request->input('caution');
        // $contactForm->save();

        return redirect('contact/index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        // $contact = ContactForm::find($id);
        // $gender = CheckFormData::checkGender($contact);
        // $age = CheckFormData::checkAge($contact);

        return view('contact.show', compact('contact','gender','age'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $contact = ContactForm::find($id);
        // if($contact->gender === 0){
        //     $gender = '男性';
        // }

        return view('contact.edit', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // $contact = ContactForm::find($id);
        // $contact->your_name = $request->input('your_name');
        // $contact->title = $request->input('title');
        // $contact->email = $request->input('email');
        // $contact->url = $request->input('url');
        // $contact->gender = $request->input('gender');
        // $contact->age = $request->input('age');
        // $contact->contact = $request->input('contact');

        // dd($contactForm, $request);
        // $caution = request->input('caution');
        // $contact->save();

        return redirect('contact/index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $contact = ContactForm::find($id);
        // $contact->delete();

        return redirect('contact/index');

    }
}