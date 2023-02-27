<x-layout>

    <div class="container mt-6">
        <div class="mt-5" >
            <div class="container d-flex justify-content-center">
                <h1 class="display-4">Edit your todo</h1>

            </div>
            <div class="container d-flex justify-content-center mt-5">
                <form action="/todos/{{$task->id}}" method="post">
                    @csrf
                    @method('patch')
                    <input type="text" name="task" value="{{$task->task}}"/>
                    <input style="display:none" type="number" name="id" value="{{$task->id}}">
                    <input type="submit" value="Edit" />
                </form>
                <br>
            </div>
        </div>
        <div class="container d-flex justify-content-center mt-3">
            <a href="/dashboard">Back</a>
        </div>

    </div>

</x-layout>
