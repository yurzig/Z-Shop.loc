@php /** @var \Illuminate\Support\ViewErrorBag $errors */ @endphp
@if($errors->any())
    <div class="admin-infobar">
        <div class="infobar-message infobar-message-danger">
            <ul>
            @foreach($errors->all() as $errorTxt)
               <li>{{ $errorTxt }}</li>
            @endforeach
            </ul>
        </div>
    </div>
@endif

@if(session('success'))
    <div class="admin-infobar">
        <div class="infobar-message infobar-message-success">
            {{ session()->get('success') }}
        </div>
    </div>
@endif

