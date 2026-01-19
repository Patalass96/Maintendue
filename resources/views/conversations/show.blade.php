@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden d-flex flex-column" style="height: 600px;">
                    <div
                        class="card-header bg-white py-3 px-4 border-0 border-bottom d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <a href="{{ route('conversations.index') }}" class="btn btn-light btn-sm rounded-circle me-3">
                                <i class="fas fa-arrow-left"></i>
                            </a>
                            <div>
                                <h6 class="mb-0 fw-bold">
                                    {{ $conversation->initiator_id === Auth::id() ? $conversation->recipient->name : $conversation->initiator->name }}
                                </h6>
                                <small class="text-muted">Conversation sur: {{ $conversation->donation->title }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4 flex-grow-1 overflow-auto" id="message-container">
                        @foreach ($messages as $msg)
                            <div class="d-flex mb-3 {{ $msg->sender_id === Auth::id() ? 'justify-content-end' : '' }}">
                                <div class="message-bubble p-3 rounded-4 {{ $msg->sender_id === Auth::id() ? 'bg-primary text-white' : 'bg-light' }}"
                                    style="max-width: 75%;">
                                    <p class="mb-1">{{ $msg->content }}</p>
                                    <small class="d-block text-end opacity-75"
                                        style="font-size: 10px;">{{ $msg->created_at->format('H:i') }}</small>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="card-footer bg-white border-0 py-3 px-4 border-top">
                        <form action="{{ route('conversations.messages.store', $conversation) }}" method="POST">
                            @csrf
                            <div class="input-group">
                                <input type="text" name="content"
                                    class="form-control rounded-pill border-0 bg-light px-4"
                                    placeholder="Tapez votre message ici..." required>
                                <button class="btn btn-primary rounded-pill ms-2 px-4" type="submit">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('message-container');
            container.scrollTop = container.scrollHeight;
        });
    </script>
@endsection
