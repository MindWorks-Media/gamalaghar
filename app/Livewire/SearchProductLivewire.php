<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class SearchProductLivewire extends Component
{

    public $search_keyword = "";
    public $resulted_Products;


    public function search($search_keyword = null)
    {
        if ($search_keyword) {
            return redirect('/producut');
            

        }
          
      
    }

    
    public function render()
    {

        if (!empty($this->search_keyword)) {

           
        } else {
            // Fetch 5 random words when the search input is empty
            $this->resulted_Products = Product::inRandomOrder()->limit(5)->get();
        }

        
        return view('livewire.search-product-livewire');
    }
}