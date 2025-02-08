<div>
    <x-system-notification />
    
    @if(!$evaluation)
    <p class="text-gray-500 mt-4">No pending evaluations.</p>    
    @else
        Evaluation: {{ $evaluation->evaluation->courseSection->course->course_code }} | {{ $evaluation->evaluation->courseSection->course->course_name }}
        <form wire:submit.prevent="submitEvaluation({{ $evaluation->user_evaluation_id }})">

            @foreach($evaluation->evaluation->survey->questionCriterias as $criteria)
                <div class="mt-4">
                    <h4 class="font-medium text-gray-700">{{ $criteria->description }}</h4>

                    @foreach ($criteria->questions as $question)
                        <div class="mt-3">
                            <label class="block text-gray-600">{{ $question->question_text }}</label>
                            
                            <div class="flex mt-2 space-x-4">
                                <label class="flex items-center">
                                    <input type="radio" wire:model.defer="responses.{{ $evaluation->user_evaluation_id }}.{{ $question->question_id }}" value="1" class="form-radio text-blue-500" />
                                    <span class="ml-2">1 - Poor</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" wire:model.defer="responses.{{ $evaluation->user_evaluation_id }}.{{ $question->question_id }}" value="2" class="form-radio text-blue-500" />
                                    <span class="ml-2">2 - Fair</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" wire:model.defer="responses.{{ $evaluation->user_evaluation_id }}.{{ $question->question_id }}" value="3" class="form-radio text-blue-500" />
                                    <span class="ml-2">3 - Good</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" wire:model.defer="responses.{{ $evaluation->user_evaluation_id }}.{{ $question->question_id }}" value="4" class="form-radio text-blue-500" />
                                    <span class="ml-2">4 - Very Good</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" wire:model.defer="responses.{{ $evaluation->user_evaluation_id }}.{{ $question->question_id }}" value="5" class="form-radio text-blue-500" />
                                    <span class="ml-2">5 - Excellent</span>
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach

            <div class="mt-4">
                <label class="block text-gray-600">Comments:</label>
                <textarea wire:model.defer="comments.{{ $evaluation->user_evaluation_id }}" class="mt-1 p-2 border rounded w-full bg-gray-50" placeholder="Add your comments here..."></textarea>
            </div>

            <button type="submit" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-200">Submit</button>

        </form>
    @endif
    
</div>
