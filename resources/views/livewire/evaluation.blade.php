<div>
    <form wire:submit.prevent="submitSurvey">
        @foreach ($surveys as $survey)
            <h1 class="text-2xl">{{ $survey->survey_name }}</h1>
            <br>

            @foreach ($survey->surveyRole as $role)
                <div class="role">
                    <h3>{{ $role->role_name }}</h3>
                    <!-- Display role-related information here -->
                </div>
            @endforeach

            @foreach ($survey->questionCriteria as $criteria)
                <div class="criteria">
                    <b><h4>{{ $criteria->description }}</h4></b>

                    <!-- Loop through the questions under this criteria -->
                    @foreach ($criteria->questions as $question)
                        <div class="question">
                            <label>{{ $question->question_text }}</label>

                            <!-- Render input for response with the same name structure for radio buttons -->
                            <div>
                                @foreach ([1, 2, 3, 4, 5] as $rating)
                                    <input type="radio" wire:model="responses.{{ $question->question_id }}" value="{{ $rating }}"> {{ $rating }}
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
            <br><br>
        @endforeach

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Submit Survey</button>
    </form>

    @if (session()->has('message'))
        <div class="mt-4 bg-green-500 text-white p-4 rounded">
            {{ session('message') }}
        </div>
    @endif
</div>
