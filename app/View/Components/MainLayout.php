<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class MainLayout extends Component
{
    public $titlePage;

    /**
     * Buat constructor untuk menerima titlePage
     */
    public function __construct($titlePage = null)
    {
        $this->titlePage = $titlePage;
    }

    /**
     * Return view utama layout
     */
    public function render(): View
    {
        return view('layouts.main');
    }
}