<form class="login" method="post">
    @csrf
    <label >Name</label><br>
    <input type="text" value="" name="name"><br>
    <label >Age</label><br>
    <input type="text" value="" name="age"><br>
    <label >Date</label><br>
    <input type="text" value="" name="date"><br>
    <label >Web</label><br>
    <input type="text" value="" name="web"><br>
    <label >Adress</label><br>
    <input type="text" value="" name="adress"><br>
    @include('error')
    <button type="submit">OK</button>
    @if(@isset($user))
            <p>Name: {{$user['name']}}</p>
            <p>Age: {{$user['age']}}</p>
            <p>Date: {{$user['date']}}</p>
            <p>Phone: {{$user['phone']}}</p>
            <p>Web: {{$user['web']}}</p>
            <p>Adress: {{$user['adress']}}</p>
    @endif
</form>