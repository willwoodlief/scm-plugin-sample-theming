
@forelse(\App\Models\Employee::getBirthdaysThisMonth() as $employee)
    @php $dob = new DateTime($employee->dob) @endphp

    <div class="event-media">
        <div class="d-flex align-items-center">
            <div class="event-box">
                <h5 class="mb-0">
                    {{$dob->format('j')}}
                </h5>
                <span>{{$dob->format('D')}}</span>
            </div>
            <div class="event-data ms-2">
                <h5 class="mb-0">
                    <a href="{{route('employee.profile',['employee_id'=>$employee->id])}}">
                        {{$employee->getName()}}
                    </a>
                </h5>
            </div>
        </div>
        <span class="text-secondary"><i class="las la-birthday-cake"></i> Happy Birthday!</span>
    </div>
@empty

    No birthdays this month

@endforelse
<h4 class="alert alert-outline-info">
    Also this was an overidden blade
</h4>
