<form action="/submit-form" method="POST">
@csrf 
{{--  these is the porpose for protection from cross site request forgery protection--}}
<label for="name">Name:</label>
<input type="text" name="name">
<button type="submit">submit</button>
</form>
