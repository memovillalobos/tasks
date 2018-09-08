<!DOCTYPE html>
<html>
  <head>
    <title>Task Management App</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </head>
  <body>
    <div class="container-fluid mt-4">
      <div class="row">
        <div class="col-md-12">
          <h2 class="float-left">Task Management App</h2>
          <div class="btn-group float-right">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createTaskModal">Create a new task</button>
            <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <span class="sr-only">Toggle Dropdown</span>
            </button>
            <div class="dropdown-menu">
              <button class="dropdown-item" data-toggle="modal" data-target="#importFileModal" href="#">Import from file</button>
            </div>
          </div>
        </div>
      </div>

      <div class="row mt-4">
        <div class="col-md-3">
          <div class="card">
            <div class="card-header">
              <h4>To Do</h4>
            </div>
            <div class="card-body">
              @foreach($tasks as $task)
                @if($task->status == 'TO_DO')
                <div class="card mb-3">
                  <div class="card-body">
                    <span class="badge badge-secondary float-right">{{ $task->estimate }} minutes</span>
                    {{ $task->task }}
                  </div>
                  <div class="card-footer text-right">
                    <form method="post" action="{{ route('tasks.update', [ $task->id ]) }}">
                      {{ csrf_field() }}
                      {{ method_field('put') }}
                      <button type="submit" class="btn btn-sm btn-primary">Move to In Progress</button>
                    </form>
                  </div>
                </div>
                @endif
              @endforeach
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card">
            <div class="card-header">
              <h4>In Progress</h4>
            </div>
            <div class="card-body">
              @foreach($tasks as $task)
                @if($task->status == 'IN_PROGRESS')
                <div class="card mb-3">
                  <div class="card-body">
                    <span class="badge badge-secondary float-right">{{ $task->estimate }} minutes</span>
                    {{ $task->task }}
                  </div>
                  <div class="card-footer text-right">
                    <form method="post" action="{{ route('tasks.update', [ $task->id ]) }}">
                      {{ csrf_field() }}
                      {{ method_field('put') }}
                      <button type="submit" class="btn btn-sm btn-primary">Move to QA</button>
                    </form>
                  </div>
                </div>
                @endif
              @endforeach
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card">
            <div class="card-header">
              <h4>QA</h4>
            </div>
            <div class="card-body">
              @foreach($tasks as $task)
                @if($task->status == 'QA')
                <div class="card mb-3">
                  <div class="card-body">
                    <span class="badge badge-secondary float-right">{{ $task->estimate }} minutes</span>
                    {{ $task->task }}
                  </div>
                  <div class="card-footer text-right">
                    <form method="post" action="{{ route('tasks.update', [ $task->id ]) }}">
                      {{ csrf_field() }}
                      {{ method_field('put') }}
                      <button type="submit" class="btn btn-sm btn-primary">Move to Done</button>
                    </form>
                  </div>
                </div>
                @endif
              @endforeach
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card">
            <div class="card-header">
              <h4>Done</h4>
            </div>
            <div class="card-body">
              @foreach($tasks as $task)
                @if($task->status == 'DONE')
                <div class="card mb-3">
                  <div class="card-body">
                    <span class="badge badge-secondary float-right">{{ $task->estimate }} minutes</span>
                    {{ $task->task }}
                  </div>
                  <div class="card-footer text-right">
                    <form method="post" action="{{ route('tasks.update', [ $task->id ]) }}">
                      {{ csrf_field() }}
                      {{ method_field('put') }}
                      <button type="submit" class="btn btn-sm btn-primary">Remove from board</button>
                    </form>
                  </div>
                </div>
                @endif
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Create Task Modal -->
    <div class="modal fade" id="createTaskModal" tabindex="-1" role="dialog" aria-labelledby="createTaskModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form method="post" action="{{ route('tasks.store') }}">
            {{ csrf_field() }}
            <div class="modal-header">
              <h5 class="modal-title" id="createTaskModalLabel">Create New Task</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label for="task">Task:</label>
                <input type="text" class="form-control" id="task" name="task" placeholder="Write a task description here...">
              </div>
              <div class="form-group">
                <label for="responsible">Responsible:</label>
                <input type="text" class="form-control" id="responsible" name="responsible" placeholder="Set the name of the task owner here...">
              </div>
              <div class="form-group">
                <label for="estimate">Duration:</label>
                <input type="text" class="form-control" id="estimate" name="estimate" placeholder="Enter a time estimation for the task...">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Create Task</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Import File Modal -->
    <div class="modal fade" id="importFileModal" tabindex="-1" role="dialog" aria-labelledby="importFileModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form action="{{ route('tasks.import') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="modal-header">
              <h5 class="modal-title" id="importFileModalLabel">Import Tasks from File</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label for="file">File:</label>
                <input type="file" class="form-control-file" id="file" name="file">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Import File</button>
            </div>
          </form>
        </div>
      </div>
    </div>

  </body>
</html>
