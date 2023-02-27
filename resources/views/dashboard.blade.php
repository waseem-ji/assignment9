<x-layout>
    <section class="vh-100">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col">
          <div class="card" id="list1" style="border-radius: .75rem; background-color: #eff1f2;">
            <div class="card-body py-4 px-4 px-md-5">

              <p class="h1 text-center mt-3 mb-4 pb-3 text-primary">
                <i class="fas fa-check-square me-1"></i>
                <u>My Todo-s</u>
              </p>

              <div class="pb-2">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex flex-row align-items-center">
                        <form action="/todos" method="POST">
                            @csrf
                            <input type="text" name="task" class="form-control form-control-lg" id="exampleFormControlInput1"
                            placeholder="Add new...">
                            <a href="#!" data-mdb-toggle="tooltip" title="Set due date"><i
                                class="fas fa-calendar-alt fa-lg me-3"></i></a>
                                <div>
                                    <button type="submit" class="btn btn-primary">Add</button>
                                </div>
                        </form>
                    </div>
                  </div>
                </div>
              </div>

              <hr class="my-4">


              @foreach ($tasks as $task)
              <ul class="list-group list-group-horizontal rounded-0 bg-transparent">
                <li
                  class="list-group-item d-flex align-items-center ps-0 pe-3 py-1 rounded-0 border-0 bg-transparent">
                  <div class="form-check">
                    <input class="form-check-input me-0" type="checkbox" value="" id="flexCheckChecked1"
                      aria-label="..." checked />
                  </div>
                </li>
                <li
                  class="list-group-item px-3 py-1 d-flex align-items-center flex-grow-1 border-0 bg-transparent">
                  <p class="lead fw-normal mb-0">{{$task->task}} </p>
                </li>
                <li class="list-group-item ps-3 pe-0 py-1 rounded-0 border-0 bg-transparent">
                  <div class="d-flex flex-row justify-content-around mb-1">


                    <a href="todos/{{$task->id}}/edit" class="btn btn-primary mr-3"> EDIT</a>
                    <a href="todos/{{$task->id}}/delete" class="btn btn-danger ml-3"> DELETE</a>



                  </div>

                </li>
              </ul>
              <hr class="my-2">
              @endforeach



            </div>
          </div>
        </div>
      </div>
    </div>
 <!-- Button trigger modal -->


  </section>





</x-layout>
