<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
        public function calendarMain()
        {
            return view('calendarMain');
        }

        public function pageError()
        {
            return view('pageError');
        }

 

        public function gallery()
        {
            return view('gallery');
        }

        public function imageUpload()
        {
            return view('imageUpload');
        }

 
        public function pricing()
        {
            return view('pricing');
        }

        public function starred()
        {
            return view('starred');
        }

        public function termsCondition()
        {
            return view('termsCondition');
        }

        public function typography()
        {
            return view('typography');
        }

        public function veiwDetails()
        {
            return view('veiwDetails');
        }

        public function widgets()
        {
            return view('widgets');
        }

}
