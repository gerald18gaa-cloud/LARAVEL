<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>TaskFlow - Task Manager</title>

    <style>
        * {
            box-sizing: border-box;
        }

        :root {
            --primary: #4f46e5;
            --primary-dark: #3730a3;
            --text: #172033;
            --muted: #64748b;
            --border: #e2e8f0;
            --background: #f5f7fb;
            --white: #ffffff;
        }

        body {
            margin: 0;
            min-height: 100vh;
            padding: 24px;
            font-family: Arial, sans-serif;
            background: var(--background);
            color: var(--text);
        }

        .app-shell {
            width: 100%;
            max-width: 1100px;
            margin: auto;
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 24px;
            border: 1px solid var(--border);
            border-radius: 14px;
            background: var(--white);
            box-shadow: 0 4px 15px rgba(15, 23, 42, 0.05);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--text);
            font-size: 21px;
            font-weight: bold;
        }

        .brand-icon {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            background: var(--primary);
            color: white;
            font-size: 19px;
        }

        .topbar-link {
            color: var(--primary);
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
        }

        .topbar-link:hover {
            color: var(--primary-dark);
        }

        .welcome-section {
            margin: 28px 0;
        }

        .welcome-section h1 {
            margin: 0;
            font-size: 32px;
            letter-spacing: -0.5px;
        }

        .welcome-section p {
            margin: 8px 0 0;
            color: var(--muted);
            font-size: 16px;
        }

        .layout {
            display: grid;
            grid-template-columns: 360px 1fr;
            gap: 24px;
            align-items: start;
        }

        .card {
            padding: 26px;
            border: 1px solid var(--border);
            border-radius: 14px;
            background: var(--white);
            box-shadow: 0 5px 18px rgba(15, 23, 42, 0.05);
        }

        .card-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 22px;
        }

        .card-heading h2 {
            margin: 0;
            font-size: 20px;
        }

        .task-count {
            padding: 5px 10px;
            border-radius: 20px;
            background: #eef2ff;
            color: var(--primary);
            font-size: 12px;
            font-weight: bold;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            color: #334155;
            font-size: 14px;
            font-weight: bold;
        }

        input,
        textarea {
            width: 100%;
            padding: 12px 13px;
            border: 1px solid var(--border);
            border-radius: 8px;
            outline: none;
            font-family: Arial, sans-serif;
            font-size: 14px;
            transition: 0.2s;
        }

        textarea {
            min-height: 120px;
            resize: vertical;
        }

        input:focus,
        textarea:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12);
        }

        .submit-button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background: var(--primary);
            color: white;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.2s;
        }

        .submit-button:hover {
            background: var(--primary-dark);
        }

        .success {
            margin-bottom: 22px;
            padding: 13px 15px;
            border: 1px solid #bbf7d0;
            border-radius: 8px;
            background: #f0fdf4;
            color: #166534;
            font-size: 14px;
        }

        .error {
            margin: 6px 0 0;
            color: #dc2626;
            font-size: 13px;
        }

        .task-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .task {
            padding: 18px;
            border: 1px solid var(--border);
            border-left: 4px solid var(--primary);
            border-radius: 10px;
            background: #fbfdff;
        }

        .task-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
        }

        .task h3 {
            margin: 0;
            color: var(--text);
            font-size: 16px;
        }

        .task-description {
            margin: 10px 0;
            color: var(--muted);
            font-size: 14px;
            line-height: 1.5;
        }

        .status-badge {
            flex-shrink: 0;
            padding: 5px 9px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
        }

        .status-complete {
            background: #dcfce7;
            color: #166534;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .empty-state {
            padding: 35px 15px;
            color: var(--muted);
            text-align: center;
            font-size: 14px;
        }

        .footer {
            margin-top: 28px;
            color: #94a3b8;
            text-align: center;
            font-size: 13px;
        }

        @media (max-width: 800px) {
            body {
                padding: 15px;
            }

            .layout {
                grid-template-columns: 1fr;
            }

            .topbar {
                padding: 15px 18px;
            }

            .welcome-section h1 {
                font-size: 27px;
            }
        }

        @media (max-width: 480px) {
            .brand {
                font-size: 18px;
            }

            .topbar-link {
                font-size: 12px;
            }

            .card {
                padding: 20px;
            }

            .task-header {
                flex-direction: column;
            }

            .status-badge {
                align-self: flex-start;
            }
        }
    </style>
</head>

<body>

<div class="app-shell">

    <nav class="topbar">
        <div class="brand">
            <div class="brand-icon">✓</div>
            My Task Management
        </div>

        <a href="{{ url('/') }}" class="topbar-link">
            Home
        </a>
    </nav>

    <section class="welcome-section">
        <h1>Good day, let’s stay organized.</h1>
        <p>Create tasks, track progress, and manage your work efficiently.</p>
    </section>

    @if (session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    <main class="layout">

        <section class="card">
            <div class="card-heading">
                <h2>Create a Task</h2>
            </div>

            <form action="{{ route('tasks.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="task_title">Task title</label>

                    <input
                        type="text"
                        id="task_title"
                        name="task_title"
                        value="{{ old('task_title') }}"
                        placeholder="Example: Submit project report"
                        required
                    >

                    @error('task_title')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description">Description</label>

                    <textarea
                        id="description"
                        name="description"
                        placeholder="Add details about this task..."
                    >{{ old('description') }}</textarea>

                    @error('description')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="submit-button">
                    + Add Task
                </button>
            </form>
        </section>

        <section class="card">
            <div class="card-heading">
                <h2>Your Tasks</h2>

                <span class="task-count">
                    {{ $tasks->count() }} total
                </span>
            </div>

            @forelse ($tasks as $task)
                <div class="task-list">
                    <article class="task">
                        <div class="task-header">
                            <h3>{{ $task->task_title }}</h3>

                            @if ($task->completed)
                                <span class="status-badge status-complete">
                                    Completed
                                </span>
                            @else
                                <span class="status-badge status-pending">
                                    Pending
                                </span>
                            @endif
                        </div>

                        <p class="task-description">
                            {{ $task->description ?: 'No description provided.' }}
                        </p>
                    </article>
                </div>
            @empty
                <div class="empty-state">
                    <p>No tasks have been added yet.</p>
                    <p>Create your first task using the form.</p>
                </div>
            @endforelse
        </section>

    </main>

    <footer class="footer">
        TaskManagement &copy; {{ date('Y') }}. Simple task management.
    </footer>

</div>

</body>
</html>