@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-white py-4 px-4 border-0">
                        <h2 class="h4 mb-0 fw-bold text-primary"><i class="fas fa-comments me-2"></i>Mes Conversations</h2>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            @forelse($conversations as $conv)
                                @php
                                    $otherUser = $conv->initiator_id === Auth::id() ? $conv->recipient : $conv->initiator;
                                    $lastMessage = $conv->messages->first();
                                @endphp
<a href="{{ route('conversations.show', $conv) }}"
                                    class="list-group-item list-group-item-action py-3 px-4 border-0 border-bottom">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                                style="width: 50px; height: 50px;">
                                                <i class="fas fa-user"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <h6 class="mb-0 fw-bold">{{ $otherUser->name }}</h6>
                                                <small class="text-muted">{{ $conv->last_message_at->diffForHumans() }}</small>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <p class="mb-0 text-muted small text-truncate" style="max-width: 400px;">
                                                    {{ $lastMessage ? $lastMessage->content : 'Pas de message.' }}
                                                </p>
@if($conv->donation)
                                                    <span
                                                        class="badge bg-light text-primary rounded-pill small">{{ $conv->donation->title }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div class="text-center py-5">
                                    <i class="fas fa-comment-slash fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Vous n'avez pas encore de conversations.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0 py-3">
                        {{ $conversations->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
