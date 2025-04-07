<div class="bg-white p-4 font-TT flex justify-center">
    <style>
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

        .error-message {
            color: #923534;
            background-color: rgba(146, 53, 52, 0.1);
            padding: 0.75rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            font-weight: 500;
            display: none;
        }

        .error-message.show {
            display: block;
            animation: fadeIn 0.3s ease-out;
        }

        .question-required {
            border: 2px solid #923534;
            box-shadow: 0 0 0 2px rgba(146, 53, 52, 0.2);
            border-radius: 0.5rem;
            padding: 1rem;
        }
    </style>

        <x-system-notification />

        @if(!$evaluation)
            <div class="rounded-xl p-8 text-center border border-slate-200 bg-slate-50">
                <p class="text-slate-600 text-xl">No pending evaluations.</p>
            </div>
        @else
            <div class="p-4 sm:p-8w w-full lg:w-1/2">
                <h2 class="text-lg sm:text-xl font-normal text-slate-700 text-center mb-4 flex justify-between">
                    <div>{{ $evaluation->evaluation->courseSection->facultyCourses->first()->faculty->faculty_name }}</div>
                    <div>{{ $evaluation->evaluation->courseSection->section->section_code }}</div>
                </h2>
                <h2 class="text-xl sm:text-2xl font-semibold text-slate-700 text-center mb-4">
                    {{ $evaluation->evaluation->courseSection->course->course_code }} | {{ $evaluation->evaluation->courseSection->course->course_name }}
                </h2>

                <div class="text-center mb-4">
                    {{-- <p class="text-sm sm:text-base text-slate-600"><strong>Rating Guide:</strong></p> --}}
                    <p class="text-xs sm:text-sm text-slate-500">1 - Does Not Met Standard | 2 - Partially Meets Standard | 3 - Meets Standard | 4 - Exceeds Standard | 5 - Outstanding</p>
                </div>
                
                <div id="validationError" class="error-message">
                    Please answer all questions before submitting the evaluation.
                </div>

                <div class="progress-bar mb-8">
                    <div id="progressFill" class="progress-bar-fill" style="width: 0%"></div>
                </div>
                
                <form wire:submit.prevent="submitEvaluation({{ $evaluation->user_evaluation_id }})" id="evaluationForm">
                    @php
                        $questionIndex = 0;
                        $totalQuestions = $evaluation->evaluation->survey->questionCriterias->flatMap->questions->count();
                    @endphp

                    @foreach($evaluation->evaluation->survey->questionCriterias as $criteriaIndex => $criteria)
                        @foreach ($criteria->questions as $question)
                            <div id="question-{{ $questionIndex }}" 
                                class="question-page hidden {{ $questionIndex === 0 ? 'active' : '' }} mb-4 sm:mb-8" 
                                data-criteria="{{ $criteria->description }}"
                                data-question-id="{{ $question->question_id }}">
                                
                                {{-- Criteria --}}
                                <h3 class="text-center font-medium text-slate-900 mb-4 sm:mb-6">**{{ $criteria->description }}**</h3>

                                <!-- Question Text -->
                                <div class="flex justify-center">
                                    <h3 class="text-md sm:text-xl font-silka text-center font-normal text-slate-900 mb-4 sm:mb-6">
                                        {{ $question->question_text }}
                                    </h3>
                                </div>

                                <!-- Rating System -->
                                <div class="rating flex flex-row-reverse justify-center items-center">
                                    @for ($i = 5; $i >= 1; $i--)
                                        <input 
                                            class="hidden question-input"
                                            type="radio" 
                                            id="star{{ $question->question_id }}-{{ $i }}"
                                            name="responses[{{ $evaluation->user_evaluation_id }}][{{ $question->question_id }}]"
                                            value="{{ $i }}"
                                            wire:model.defer="responses.{{ $evaluation->user_evaluation_id }}.{{ $question->question_id }}"
                                        >
                                        <label 
                                            for="star{{ $question->question_id }}-{{ $i }}" 
                                            class="p-2 text-3xl sm:p-5 sm:text-4xl transition-all ease-custom-bezier duration-300 text-[#DDD] cursor-pointer flex justify-center items-center transform origin-center hover:text-[#923534] hover:scale-110"
                                        >
                                            <i class="fa fa-star align-middle" aria-hidden="true"></i>
                                        </label>
                                    @endfor
                                </div>
                                
                                <div class="flex justify-center mt-8 sm:mt-12 gap-5">
                                    @if($questionIndex > 0)
                                        <button 
                                            type="button"
                                            class="px-4 sm:px-6 py-2 rounded-full bg-[#DDD] text-slate-700 font-medium transition hover:bg-opacity-90 text-sm sm:text-base"
                                            onclick="previousQuestion({{ $questionIndex }})"
                                        >
                                            <i class="fa-solid fa-arrow-left"></i>
                                        </button>
                                    @endif
                                    @if($questionIndex < $totalQuestions - 1)
                                        <button 
                                            type="button"
                                            class="px-4 sm:px-6 py-2 rounded-full bg-[#923534] text-white font-medium transition hover:bg-opacity-90 text-sm sm:text-base"
                                            onclick="nextQuestion({{ $questionIndex }})"
                                        >
                                            <i class="fa-solid fa-arrow-right"></i>
                                        </button>
                                    @else
                                        <button 
                                            type="button"
                                            class="px-4 sm:px-6 py-2 rounded-full bg-[#923534] text-white font-medium transition hover:bg-opacity-90 text-sm sm:text-base"
                                            onclick="showComments()"
                                        >
                                            <i class="fa-solid fa-arrow-right"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                            @php $questionIndex++; @endphp
                        @endforeach
                    @endforeach

                    <div id="comments-section" class="question-page hidden mb-4 sm:mb-8">
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
                                <i class="fa-solid fa-arrow-left"></i>
                            </button>
                            <button 
                                type="button"
                                id="submitButton"
                                class="px-6 sm:px-8 py-2 sm:py-3 rounded-full bg-[#923534] text-white font-medium transition hover:bg-opacity-90 text-sm sm:text-base"
                            >
                                Submit
                            </button>
                        </div>
                    </div>
                </form>
        @endif
    </div>

    {{-- <div id="successMessage" class="fixed inset-0 flex items-center justify-center bg-black/50">
        <div class="bg-white rounded-xl p-6 sm:p-12 text-center shadow-xl mx-4 sm:mx-0">
            <div class="text-4xl sm:text-6xl mb-4">🎉</div>
            <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 mb-4">Thank You!</h2>
            <p class="text-lg sm:text-xl text-slate-600">Your feedback has been submitted successfully</p>
        </div>
    </div> --}}

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

        function validateForm() {
            const evaluationId = {{ $evaluation->user_evaluation_id ?? 'null' }};
            if (!evaluationId) return true;

            const errorMessage = document.getElementById('validationError');
            const unansweredQuestions = [];

            // Check each question
            for (let i = 0; i < totalQuestions; i++) {
                const questionDiv = document.getElementById(`question-${i}`);
                const questionId = questionDiv.getAttribute('data-question-id');
                const inputs = document.querySelectorAll(`input[name="responses[${evaluationId}][${questionId}]"]:checked`);
                
                if (inputs.length === 0) {
                    unansweredQuestions.push(i);
                    questionDiv.classList.add('question-required');
                } else {
                    questionDiv.classList.remove('question-required');
                }
            }

            // Show error message and navigate to first unanswered question if validation fails
            if (unansweredQuestions.length > 0) {
                errorMessage.classList.add('show');
                
                // Navigate to the first unanswered question
                document.querySelectorAll('.question-page').forEach(page => {
                    page.classList.remove('active');
                });
                document.getElementById('comments-section').classList.remove('active');
                
                const firstUnansweredQuestion = document.getElementById(`question-${unansweredQuestions[0]}`);
                firstUnansweredQuestion.classList.add('active');
                currentQuestion = unansweredQuestions[0];
                updateProgressBar();
                
                setTimeout(() => {
                    errorMessage.classList.remove('show');
                }, 5000);
                
                return false;
            }
            
            errorMessage.classList.remove('show');
            return true;
        }

        // Initialize submit button handler
        document.addEventListener('DOMContentLoaded', function() {
            const submitButton = document.getElementById('submitButton');
            if (submitButton) {
                submitButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (validateForm()) {
                        document.getElementById('evaluationForm').dispatchEvent(new Event('submit', {
                            bubbles: true,
                            cancelable: true
                        }));
                    }
                });
            }
            
            // Add event listeners to all rating inputs to reset error styling on selection
            document.querySelectorAll('.question-input').forEach(input => {
                input.addEventListener('change', function() {
                    const questionDiv = this.closest('.question-page');
                    if (questionDiv) {
                        questionDiv.classList.remove('question-required');
                    }
                });
            });
        });

        updateProgressBar();
    </script>
</div>

