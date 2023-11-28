<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\Livewire;

class RejectionModal extends Component
{
    public $productRequest;
    public $reason;

    public function render()
    {
        return view('livewire.rejection-modal');
    }

    public function rejectProductRequest()
    {
        // Your rejection logic here
        $this->productRequest->status = 'Rejected';
        $this->productRequest->reason_of_rejection = $this->reason;
        $this->productRequest->save();

        // Emit Livewire event to close the modal
        Livewire::emit('closeRejectionModal');

        // You can return a response or redirect if needed
        return response()->json(['message' => 'Product request rejected successfully']);
    }

    public function setProductRequest($productRequest)
    {
        $this->productRequest = $productRequest;
    }
}
