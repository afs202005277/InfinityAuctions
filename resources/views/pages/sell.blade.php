@extends('layouts.app')

@section('content')
    @if($errors->any())
        <h4 class="error">{{$errors->first()}}</h4>
    @endif

    @if (!Auth::user())
        <p class="not-auth">Please <a href="{{ route('login') }}">login</a> to proceed.</p>
    @else
        <form method="POST" class="sell" action="{{ route('sell') }}" enctype="multipart/form-data">
            {{ csrf_field() }}

            <h3>Sell</h3>

            <label for="title">Title</label>
            <input id="title" placeholder="Name your auction" type="text" name="title" value="{{ old('title') }}" required autofocus>
            @if ($errors->has('title'))
            <span class="error">
                {{ $errors->first('title') }}
            </span>
            @endif

            <label for="desc">Description</label>
            <textarea id="desc" placeholder="Describe your auction" name="desc" value="{{ old('desc') }}" required></textarea>
            @if ($errors->has('desc'))
            <span class="error">
                {{ $errors->first('desc') }}
            </span>
            @endif

            <label for="images">Images</label>
            <input id="images" name="images[]" value="{{ old('images') }}" type="file" multiple required>
            @if ($errors->has('images'))
            <span class="error">
                {{ $errors->first('images') }}
            </span>
            @endif

            <label for="baseprice">Base Price</label>
            <input id="baseprice" placeholder="Name the starting price" type="number" name="baseprice" value="{{ old('baseprice') }}" required>
            @if ($errors->has('baseprice'))
            <span class="error">
                {{ $errors->first('baseprice') }}
            </span>
            @endif

            <label for="startdate">Start Date</label>
            <input id="startdate" type="date" name="startdate" value="{{ old('startdate') }}" required>
            @if ($errors->has('startdate'))
            <span class="error">
                {{ $errors->first('startdate') }}
            </span>
            @endif

            <label for="enddate">End Date</label>
            <input id="enddate" type="date" name="enddate" value="{{ old('enddate') }}" required>
            @if ($errors->has('enddate'))
            <span class="error">
                {{ $errors->first('enddate') }}
            </span>
            @endif

            <label for="buynow">Buy Now</label>
            <input id="buynow" placeholder="Leave blank to not allow buy now" type="number" name="buynow" value="{{ old('buynow') }}">
            @if ($errors->has('buynow'))
            <span class="error">
                {{ $errors->first('buynow') }}
            </span>
            @endif

            <div class="categories">
            <legend>Categories</legend>
            @foreach ($categories as $category)
                <input type="checkbox" id="{{$category->name}}" name="{{$category->name}}">
                <label for="{{$category->name}}">{{$category->name}}</label><br>
            @endforeach
            </div>

            <button type="submit">SUBMIT</button>

        </form>
    @endif
@endsection
