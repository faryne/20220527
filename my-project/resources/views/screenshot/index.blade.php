<!doctype html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Screenshot</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container-fluid">
        <h1 class="">Screenshot</h1>
        <form method="post" action="{{ route('screenshot.capture')  }}">
            @if ($errors->any())
                <p class="alert alert-warning">{{ $errors->first("url") }}</p>
            @endif
            @if (isset($result))
                {{$result}}
            @endif
            <input type="text" name="url" required url class="form-control" value="@if(isset($oldValue)) {{ $oldValue }} @endif "/>
            <button type="submit" class="btn btn-primary">Submit</button>
            {{ csrf_field() }}
        </form>

        <table class="table table-striped">
            <thead>
            <tr>
                <th>網址</th>
                <th>標題</th>
                <th>圖片路徑</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($screenshots as $screenshot)
                <tr>
                    <td>{{ $screenshot->url }}</td>
                    <td>{{ $screenshot->title }}</td>
                    <td>{{ $screenshot->path  }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">尚無資料</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        {{ $screenshots->onEachSide(5)->links() }}
    </div>
</body>
</html>
