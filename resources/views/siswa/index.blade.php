@extends('layout.template')
@section('konten')
{{-- data --}}
<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
                <!-- Authentication Links -->
                @guest
                @if (Route::has('login'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @endif

                @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
                @endif
                @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
<div class="my-3 p-3 bg-body rounded shadow-sm">
    <div class="pb-3">
        <form action="{{ url('siswa')}} " method="get" class="d-flex">
            <input type="search" name="katakunci" class="form-control me-1" value="{{ Request::get('katakunci') }}"
                placeholder="Masukan kata kunci" aria-label="Search">
            <input type="submit" class="btn btn-secondary" value="Cari">
        </form>
    </div>
    <div class="pb-3">
        <a href=" {{ url('siswa/create') }} " class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Data</a>
    </div></a>
</div>

<table class="table table-striped">
    <thead class="table-primary">
        <tr>
            <th class="col-md-1 no-sort">No</th>
            <th class="col-md">NIS</th>
            <th class="col-md">Nama</th>
            <th class="col-md">Jenis Kelamin</th>
            <th class="col-md">Tempat Tanggal Lahir</th>
            <th class="col-md-1">Kelas</th>
            <th class="col-md-1">Jurusan</th>
            <th class="col-md no-sort">Gambar</th>
            <th class="col-md-2 no-sort">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @php
        $i = $data->firstItem()
        @endphp
        @foreach ($data as $item)
        <tr>
            <td>{{ $i }}</td>
            <td>{{ $item->nis }}</td>
            <td>{{ $item->nama }}</td>
            <td>{{ $item->jk }}</td>
            <td>{{ $item->ttl }}</td>
            <td>{{ $item->kelas }}</td>
            <td>{{ $item->jurusan }}</td>
            <td>
                {{-- {{$item->image}} --}}
                @if ($item->image != '')
                <img src="{{asset('gambar/'.$item->image)}}" width="100">
                @else
                <img src="{{asset('images/default.png')}}" width="100">
                @endif
            </td>
            <td>
                <a href="{{ url('siswa/' . $item->nis . '/edit') }} " class="btn btn-warning btn-sm">Edit</a>
                <form action="{{'siswa/' . $item->nis}}" method="post" class="d-inline"
                    onsubmit="return confirm('Yakin akan menghapus?')">
                    @csrf
                    @method('delete')
                    <button type="submit" name="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </td>
        </tr>
        @php
        $i++
        @endphp
        @endforeach
    </tbody>
</table>
{{ $data->withQueryString()->links() }}
</div>
{{-- end data --}}

@endsection