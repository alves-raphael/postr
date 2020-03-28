@extends('master')

@section('title') Publicações @endsection

@section('body')
    <a href="{{route('post.create')}}" class="ui green button"> <i class="icon plus"></i> Novo</a>
    <table class="ui celled striped table">
        <thead>
            <tr>
                <th>
                    Sample 1
                </th>
                <th>
                    Sample 2
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Initial commit</td>
                <td class="right aligned collapsing">10 hours ago</td>
            </tr>
            <tr>
                <td>Initial commit</td>
                <td class="right aligned">10 hours ago</td>
            </tr>
            <tr>
                <td>Initial commit</td>
                <td class="right aligned">10 hours ago</td>
            </tr>
            <tr>
                <td>Initial commit</td>
                <td class="right aligned">10 hours ago</td>
            </tr>
            <tr>
                <td>Initial commit</td>
                <td class="right aligned">10 hours ago</td>
            </tr>
        </tbody>
    </table>
@endsection