@extends('layouts.app')

@section('title', 'Foire Aux Questions')

@section('content')
<div class="faq-container" style="max-width: 800px; margin: 50px auto; padding: 0 20px;">
    <div class="faq-header" style="text-align: center; margin-bottom: 40px;">
        <h1 style="color: #1a1a1a; font-size: 2.5rem; margin-bottom: 10px;">Comment pouvons-nous vous aider ?</h1>
        <p style="color: #666;">Retrouvez les questions les plus fréquentes sur MainTendue.</p>
    </div>

    @forelse($faqs as $category => $items)
        <div class="faq-category-section" style="margin-bottom: 30px;">
            <h3 style="text-transform: uppercase; color: #3b82f6; font-size: 0.9rem; letter-spacing: 1px; margin-bottom: 15px; border-bottom: 2px solid #f0f0f0; padding-bottom: 5px;">
                {{ $category == 'general' ? 'Général' : ($category == 'donor' ? 'Donateurs' : 'Associations') }}
            </h3>

            @foreach($items as $faq)
                <div class="faq-item" style="background: #fff; border: 1px solid #e5e7eb; border-radius: 8px; margin-bottom: 10px; overflow: hidden;">
                    <button class="faq-question" style="width: 100%; text-align: left; padding: 18px 20px; background: none; border: none; display: flex; justify-content: space-between; align-items: center; cursor: pointer; font-weight: 600; color: #374151;">
                        {{ $faq->question }}
                        <i class="fas fa-chevron-down" style="font-size: 0.8rem; transition: transform 0.3s;"></i>
                    </button>
                    <div class="faq-answer" style="max-height: 0; overflow: hidden; transition: max-height 0.3s ease-out; background: #f9fafb;">
                        <p style="padding: 20px; color: #6b7280; line-height: 1.6; margin: 0;">
                            {{ $faq->answer }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    @empty
        <p style="text-align: center; color: #999;">Aucune question disponible pour le moment.</p>
    @endforelse
</div>
@endsection

@section('scripts')
<script>
    document.querySelectorAll('.faq-question').forEach(button => {
        button.addEventListener('click', () => {
            const faqItem = button.parentElement;
            const answer = button.nextElementSibling;
            const icon = button.querySelector('i');

            // Fermer les autres
            document.querySelectorAll('.faq-answer').forEach(el => {
                if (el !== answer) {
                    el.style.maxHeight = null;
                    el.parentElement.querySelector('i').style.transform = 'rotate(0deg)';
                }
            });

            // Basculer l'actuel
            if (answer.style.maxHeight) {
                answer.style.maxHeight = null;
                icon.style.transform = 'rotate(0deg)';
            } else {
                answer.style.maxHeight = answer.scrollHeight + "px";
                icon.style.transform = 'rotate(180deg)';
            }
        });
    });
</script>
@endsection