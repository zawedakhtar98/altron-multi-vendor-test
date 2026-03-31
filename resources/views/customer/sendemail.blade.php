@extends('layout.app');
@section('main')

<div class="container">
    <h2>Send Email To Multiple user with half hour</h2>
    <div class="item-align-center">
        <form action="#">
            <div class="form-group">
                <label for="subject">Suject</label>
                <input type="text" name="subject" id="subject" class="form-control" placeholder="Subject">
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea name="message" id="message" cols="30" rows="10" class="form-control" placeholder="Message body"></textarea>
            </div>            
            <input type="submit" value="Submit" name="submit" class="btn btn-primary w-100">
        </form>
    </div>
</div>
@endsection