<div class="min-h-screen bg-white p-8 font-TT">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        * {
            font-family: 'Poppins', sans-serif;
        }

        .font-TT, .font-silka {
            font-family: 'TT', 'Silka', sans-serif;
        }

        .rating {
            display: inline-flex;
            flex-direction: row-reverse;
            gap: 0.5rem;
        }

        .rating input {
            display: none;
        }

        .rating label {
            cursor: pointer;
            width: 2.5rem;
            height: 2.5rem;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 2rem;
            color: #CBD5E1; /* Tailwind slate-300 */
            transition: all 0.3s;
        }

        @media (min-width: 640px) {
            .rating label {
                width: 3rem;
                height: 3rem;
                font-size: 2.5rem;
            }
        }

        .rating label:hover,
        .rating label:hover ~ label,
        .rating input:checked ~ label {
            color: #923534;
            transform: scale(1.2);
        }

        .progress-bar {
            height: 6px;
            background: #F1F5F9; /* Tailwind slate-100 */
            border-radius: 999px;
            overflow: hidden;
        }

        .progress-bar-fill {
            height: 100%;
            background: #923534;
            transition: width 0.5s ease;
        }

        .question-page {
            display: none;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .question-page.active {
            display: block;
            animation: fadeIn 0.3s ease-out;
        }
    </style>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-system-notification />

        @if(!$evaluation)
            <div class="rounded-xl p-8 text-center border border-slate-200 bg-slate-50">
                <p class="text-slate-600 text-xl">No pending evaluations.</p>
            </div>
        @else
            <div class="rounded-xl p-4 sm:p-8 border-0 sm:border sm:border-slate-200">
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 text-center mb-4 sm:mb-8">Course Evaluation</h1>
                <h2 class="text-xl sm:text-2xl font-semibold text-slate-700 text-center mb-4">
                    {{ $evaluation->evaluation->courseSection->course->course_code }} | {{ $evaluation->evaluation->courseSection->course->course_name }}
                </h2>

                <div class="progress-bar mb-8">
                    <div id="progressFill" class="progress-bar-fill" style="width: 0%"></div>
                </div>

                <form wire:submit.prevent="submitEvaluation({{ $evaluation->user_evaluation_id }})">
                    @php
                        $questionIndex = 0;
                        $totalQuestions = $evaluation->evaluation->survey->questionCriterias->flatMap->questions->count();
                    @endphp

                    @foreach($evaluation->evaluation->survey->questionCriterias as $criteriaIndex => $criteria)
                        @foreach ($criteria->questions as $question)
                            <div id="question-{{ $questionIndex }}" class="question-page {{ $questionIndex === 0 ? 'active' : '' }} mb-4 sm:mb-8">
                                <h3 class="text-lg sm:text-xl font-medium text-slate-900 mb-4 sm:mb-6">{{ $criteria->description }}</h3>
                                <div class="mb-4 sm:mb-6">
                                    <p class="text-base sm:text-lg text-slate-700 mb-3">{{ $question->question_text }}</p>
                                    <div class="rating flex justify-center">
                                        @for ($i = 5; $i >= 1; $i--)
                                            <input 
                                                type="radio" 
                                                id="star{{ $question->question_id }}-{{ $i }}"
                                                name="responses[{{ $evaluation->user_evaluation_id }}][{{ $question->question_id }}]"
                                                value="{{ $i }}"
                                                wire:model.defer="responses.{{ $evaluation->user_evaluation_id }}.{{ $question->question_id }}"
                                            >
                                            <label for="star{{ $question->question_id }}-{{ $i }}" class="text-3xl sm:text-4xl">★</label>
                                        @endfor
                                    </div>
                                </div>

                                <div class="flex justify-between mt-4 sm:mt-6">
                                    @if($questionIndex > 0)
                                        <button 
                                            type="button"
                                            class="px-4 sm:px-6 py-2 rounded-full bg-slate-300 text-slate-700 font-medium transition hover:bg-opacity-90 text-sm sm:text-base"
                                            onclick="previousQuestion({{ $questionIndex }})"
                                        >
                                            Previous
                                        </button>
                                    @endif
                                    @if($questionIndex < $totalQuestions - 1)
                                        <button 
                                            type="button"
                                            class="px-4 sm:px-6 py-2 rounded-full bg-[#923534] text-white font-medium transition hover:bg-opacity-90 text-sm sm:text-base"
                                            onclick="nextQuestion({{ $questionIndex }})"
                                        >
                                            Next
                                        </button>
                                    @else
                                        <button 
                                            type="button"
                                            class="px-4 sm:px-6 py-2 rounded-full bg-[#923534] text-white font-medium transition hover:bg-opacity-90 text-sm sm:text-base"
                                            onclick="showComments()"
                                        >
                                            Next
                                        </button>
                                    @endif
                                </div>
                            </div>
                            @php $questionIndex++; @endphp
                        @endforeach
                    @endforeach

                    <div id="comments-section" class="question-page mb-4 sm:mb-8">
                        <h3 class="text-lg sm:text-xl font-medium text-slate-900 mb-4">Additional Comments</h3>
                        <textarea 
                            wire:model.defer="comments.{{ $evaluation->user_evaluation_id }}"
                            class="w-full p-3 sm:p-4 rounded-lg bg-white text-slate-900 placeholder-slate-400 border border-slate-200 focus:ring-2 focus:ring-[#923534] focus:border-[#923534] focus:outline-none resize-none text-sm sm:text-base"
                            rows="4"
                            placeholder="Share your thoughts with us..."
                        ></textarea>

                        <div class="flex justify-between mt-4 sm:mt-6">
                            <button 
                                type="button"
                                class="px-4 sm:px-6 py-2 rounded-full bg-slate-300 text-slate-700 font-medium transition hover:bg-opacity-90 text-sm sm:text-base"
                                onclick="previousQuestion({{ $totalQuestions - 1 }})"
                            >
                                Previous
                            </button>
                            <button 
                                type="submit"
                                class="px-6 sm:px-8 py-2 sm:py-3 rounded-full bg-[#923534] text-white font-medium transition hover:bg-opacity-90 text-sm sm:text-base"
                            >
                                Submit
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        @endif
    </div>

    <div id="successMessage" class="fixed inset-0 flex items-center justify-center bg-black/50 hidden">
        <div class="bg-white rounded-xl p-6 sm:p-12 text-center shadow-xl mx-4 sm:mx-0">
            <div class="text-4xl sm:text-6xl mb-4">🎉</div>
            <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 mb-4">Thank You!</h2>
            <p class="text-lg sm:text-xl text-slate-600">Your feedback has been submitted successfully</p>
        </div>
    </div>

    <script>
        let currentQuestion = 0;
        const totalQuestions = {{ $totalQuestions }};

        function previousQuestion(index) {
            if (index > 0) {
                if (document.getElementById('comments-section').classList.contains('active')) {
                    document.getElementById('comments-section').classList.remove('active');
                    const lastQuestion = document.getElementById(`question-${index}`);
                    lastQuestion.classList.add('active');
                    lastQuestion.offsetHeight; // Trigger reflow
                } else {
                    document.getElementById(`question-${index}`).classList.remove('active');
                    const prevQuestion = document.getElementById(`question-${index - 1}`);
                    prevQuestion.classList.add('active');
                    prevQuestion.offsetHeight; // Trigger reflow
                }
                currentQuestion = index - 1;
                updateProgressBar();
            }
        }

        function nextQuestion(index) {
            if (index < totalQuestions - 1) {
                document.getElementById(`question-${index}`).classList.remove('active');
                const nextQuestion = document.getElementById(`question-${index + 1}`);
                nextQuestion.classList.add('active');
                nextQuestion.offsetHeight; // Trigger reflow
                currentQuestion = index + 1;
                updateProgressBar();
            }
        }

        function showComments() {
            document.getElementById(`question-${totalQuestions - 1}`).classList.remove('active');
            const commentsSection = document.getElementById('comments-section');
            commentsSection.classList.add('active');
            commentsSection.offsetHeight; // Trigger reflow
            currentQuestion = totalQuestions;
            updateProgressBar();
        }

        function updateProgressBar() {
            const progress = ((currentQuestion + 1) / (totalQuestions + 1)) * 100;
            document.getElementById('progressFill').style.width = `${progress}%`;
        }

        document.addEventListener('livewire:load', function () {
            Livewire.on('evaluationSubmitted', () => {
                const duration = 3000;
                const animationEnd = Date.now() + duration;
                const defaults = { startVelocity: 30, spread: 360, ticks: 60, zIndex: 0 };

                function randomInRange(min, max) {
                    return Math.random() * (max - min) + min;
                }

                const interval = setInterval(function() {
                    const timeLeft = animationEnd - Date.now();

                    if (timeLeft <= 0) {
                        return clearInterval(interval);
                    }

                    const particleCount = 50 * (timeLeft / duration);
                    
                    confetti({
                        ...defaults,
                        particleCount,
                        origin: { x: randomInRange(0.1, 0.3), y: Math.random() - 0.2 }
                    });
                    confetti({
                        ...defaults,
                        particleCount,
                        origin: { x: randomInRange(0.7, 0.9), y: Math.random() - 0.2 }
                    });
                }, 250);

                document.getElementById('successMessage').classList.remove('hidden');
                setTimeout(() => {
                    document.getElementById('successMessage').classList.add('hidden');
                }, 3000);
            });
        });

        updateProgressBar();
    </script>
</div>

