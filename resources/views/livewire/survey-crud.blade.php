<div>
    <!-- Dropdown to select the period -->
    <select wire:model="periodId" wire:change="showSurveysForPeriod">
        <option value="">Select Period</option>
        @foreach($evaluationPeriods as $period)
            <option value="{{ $period->period_id }}">{{ $period->semester }} {{ $period->academic_year }}</option>
        @endforeach
    </select>

    <!-- Display surveys -->
    <div>
        <h3>Surveys for Selected Period</h3>
       
            <ul>
                @foreach($surveys as $survey)
                    <li>{{ $survey->survey_name }}</li>
                @endforeach
            </ul>
    </div>
</div>
