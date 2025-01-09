@extends('layouts.master')

@section('content')

<div class="space-y-6">

    <!-- Evaluation Section -->
    <div class="bg-white rounded-lg p-6">
        Evaluation
    </div>

    <!-- Cards Section -->
    <div class="grid grid-rows-1 gap-5 
    sm:grid-cols-2 
    md:grid-cols-2 
    lg:grid-cols-3 
    xl:grid-cols-6">

        <x-card 
            count="{{ \App\Models\Student::count() }}" 
            label="Students" 
            icon="{{ asset('assets/icons/student.svg') }}" 
        />

        <x-card 
            count="{{ \App\Models\Faculty::count() }}" 
            label="Faculty" 
            icon="{{ asset('assets/icons/faculty.svg') }}" 
        />

        <x-card 
            count="{{ \App\Models\Course::count() }}" 
            label="Courses" 
            icon="{{ asset('assets/icons/course.svg') }}" 
        />

        <x-card 
            count="{{ \App\Models\Program::count() }}" 
            label="Programs" 
            icon="{{ asset('assets/icons/program.svg') }}" 
        />

        <x-card 
            count="{{ \App\Models\CourseSection::count() }}" 
            label="Sections" 
            icon="{{ asset('assets/icons/section.svg') }}" 
        />

        <x-card 
            count="{{ \App\Models\Student::count() }}" 
            label="Users" 
            icon="{{ asset('assets/icons/account.svg') }}" 
        />

    </div>

    <!-- Progress Section -->
    <div class="grid gap-5 
    sm:grid-cols-2 
    md:grid-cols-2 
    lg:grid-cols-3 
    xl:grid-cols-4">

        <div class="bg-white rounded-lg p-6
        sm:col-span-2
        md:col-span-2
        lg:col-span-1
        xl:col-span-1">

        </div>

        <div class="bg-white rounded-lg p-6
        sm:col-span-2
        md:col-span-2
        lg:col-span-2
        xl:col-span-2">

        </div>

        <div class="bg-white rounded-lg p-6
        sm:col-span-2
        md:col-span-2
        lg:col-span-3 
        xl:col-span-1 ">
        
        </div>

    </div>

    <!-- Monitoring Section -->
    <div class="grid gap-5 
    sm:grid-cols-1 
    md:grid-cols-1 
    lg:grid-cols-2 
    xl:grid-cols-2">

        <div class="bg-white rounded-lg p-6
        sm:col-span-1
        md:col-span-1
        lg:col-span-2
        xl:col-span-1">

        </div>

        <div class="bg-white rounded-lg p-6
        sm:col-span-1
        md:col-span-1
        lg:col-span-2
        xl:col-span-1">

        </div>

    </div>

</div>

{{-- <div class="container">
        
    <!-- Courses -->
    <div class="courses">
        <h3>Courses</h3>
        @foreach ($courses as $course)
            <div>
                <strong>Course Name:</strong> {{ $course->course_name }}<br>
                <strong>Description:</strong> {{ $course->course_description }}<br>
                <strong>Course Code:</strong> {{ $course->course_code }}<br>
                <strong>Department ID:</strong> {{ $course->department_id }}<br><br>
            </div>
        @endforeach
    </div>

    <!-- Course Sections -->
    <div class="course-sections">
        <h3>Course Sections</h3>
        @foreach ($courseSections as $section)
            <div>
                <strong>Course ID:</strong> {{ $section->course_id }}<br>
                <strong>Section:</strong> {{ $section->section }}<br>
                <strong>Period ID:</strong> {{ $section->period_id }}<br><br>
            </div>
        @endforeach
    </div>

    <!-- Departments -->
    <div class="departments">
        <h3>Departments</h3>
        @foreach ($departments as $department)
            <div>
                <strong>Department Name:</strong> {{ $department->department_name }}<br>
                <strong>Description:</strong> {{ $department->department_description }}<br>
                <strong>Department Code:</strong> {{ $department->department_code }}<br><br>
            </div>
        @endforeach
    </div>

    <!-- Evaluation Periods -->
    <div class="evaluation-periods">
        <h3>Evaluation Periods</h3>
        @foreach ($evaluationPeriods as $period)
            <div>
                <strong>Semester:</strong> {{ $period->semester }}<br>
                <strong>Academic Year:</strong> {{ $period->academic_year }}<br>
                <strong>Start Date:</strong> {{ $period->start_date }}<br>
                <strong>End Date:</strong> {{ $period->end_date }}<br>
                <strong>Status:</strong> {{ $period->status }}<br>
                <strong>Student Scoring:</strong> {{ $period->student_scoring }}<br>
                <strong>Self Scoring:</strong> {{ $period->self_scoring }}<br>
                <strong>Peer Scoring:</strong> {{ $period->peer_scoring }}<br>
                <strong>Chair Scoring:</strong> {{ $period->chair_scoring }}<br>
                <strong>Disseminated:</strong> {{ $period->disseminated }}<br>
                <strong>Is Completed:</strong> {{ $period->is_completed }}<br><br>
            </div>
        @endforeach
    </div>

    <!-- Faculties -->
    <div class="faculties">
        <h3>Faculties</h3>
        @foreach ($faculties as $faculty)
            <div>
                <strong>Username:</strong> {{ $faculty->username }}<br>
                <strong>Email:</strong> {{ $faculty->email }}<br>
                <strong>First Name:</strong> {{ $faculty->first_name }}<br>
                <strong>Last Name:</strong> {{ $faculty->last_name }}<br>
                <strong>Department ID:</strong> {{ $faculty->department_id }}<br>
                <strong>Phone Number:</strong> {{ $faculty->phone_number }}<br>
                <strong>Profile Image:</strong> <img src="{{ $faculty->profile_image }}" alt="Profile Image" width="50"><br><br>
            </div>
        @endforeach
    </div>

    <!-- Programs -->
    <div class="programs">
        <h3>Programs</h3>
        @foreach ($programs as $program)
            <div>
                <strong>Program Code:</strong> {{ $program->program_code }}<br>
                <strong>Program Name:</strong> {{ $program->program_name }}<br>
                <strong>Description:</strong> {{ $program->program_description }}<br>
                <strong>Department ID:</strong> {{ $program->department_id }}<br><br>
            </div>
        @endforeach
    </div>

    <!-- Program Chairs -->
    <div class="program-chairs">
        <h3>Program Chairs</h3>
        @foreach ($programChairs as $chair)
            <div>
                <strong>Username:</strong> {{ $chair->username }}<br>
                <strong>Email:</strong> {{ $chair->email }}<br>
                <strong>First Name:</strong> {{ $chair->first_name }}<br>
                <strong>Last Name:</strong> {{ $chair->last_name }}<br>
                <strong>Department ID:</strong> {{ $chair->department_id }}<br>
                <strong>Profile Image:</strong> <img src="{{ $chair->profile_image }}" alt="Profile Image" width="50"><br><br>
            </div>
        @endforeach
    </div>

    <!-- Program Courses -->
    <div class="program-courses">
        <h3>Program Courses</h3>
        @foreach ($programCourses as $programCourse)
            <div>
                <strong>Program ID:</strong> {{ $programCourse->program_id }}<br>
                <strong>Course ID:</strong> {{ $programCourse->course_id }}<br><br>
            </div>
        @endforeach
    </div>

    <!-- Questions -->
    <div class="questions">
        <h3>Questions</h3>
        @foreach ($questions as $question)
            <div>
                <strong>Question Text:</strong> {{ $question->question_text }}<br>
                <strong>Question Code:</strong> {{ $question->question_code }}<br>
                <strong>Criteria ID:</strong> {{ $question->criteria_id }}<br><br>
            </div>
        @endforeach
    </div>

    <!-- Question Criteria -->
    <div class="question-criteria">
        <h3>Question Criteria</h3>
        @foreach ($questionCriterias as $criteria)
            <div>
                <strong>Description:</strong> {{ $criteria->description }}<br>
                <strong>Survey ID:</strong> {{ $criteria->survey_id }}<br><br>
            </div>
        @endforeach
    </div>

    <!-- Students -->
    <div class="students">
        <h3>Students</h3>
        @foreach ($students as $student)
            <div>
                <strong>Username:</strong> {{ $student->username }}<br>
                <strong>Email:</strong> {{ $student->email }}<br>
                <strong>First Name:</strong> {{ $student->first_name }}<br>
                <strong>Last Name:</strong> {{ $student->last_name }}<br>
                <strong>Program ID:</strong> {{ $student->program_id }}<br>
                <strong>Phone Number:</strong> {{ $student->phone_number }}<br>
                <strong>Profile Image:</strong> <img src="{{ $student->profile_image }}" alt="Profile Image" width="50"><br><br>
            </div>
        @endforeach
    </div>

    <!-- Student Courses -->
    <div class="student-courses">
        <h3>Student Courses</h3>
        @foreach ($studentCourses as $studentCourse)
            <div>
                <strong>Student ID:</strong> {{ $studentCourse->student_id }}<br>
                <strong>Course Section ID:</strong> {{ $studentCourse->course_section_id }}<br><br>
            </div>
        @endforeach
    </div>

    <!-- Surveys -->
    <div class="surveys">
        <h3>Surveys</h3>
        @foreach ($surveys as $survey)
            <div>
                <strong>Survey Name:</strong> {{ $survey->survey_name }}<br>
                <strong>Target Role:</strong> {{ $survey->target_role }}<br><br>
            </div>
        @endforeach
    </div>

</div> --}}

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>





@endsection
