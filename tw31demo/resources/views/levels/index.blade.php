@extends('layouts.app')

@section('title', 'Membership Levels')

@section('content')
    <div class="topbar">
        <div>
            <h1>Membership Levels</h1>
            <p>Manage fees, benefits, and validity periods.</p>
        </div>

        <a href="{{ route('levels.create') }}" class="btn">
            + Add Level
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif

    <div class="card">
        @if ($levels->count())
            <table>
                <thead>
                    <tr>
                        <th>Level</th>
                        <th>Fee</th>
                        <th>Validity</th>
                        <th>Benefits</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($levels as $level)
                        <tr>
                            <td>
                                <strong>{{ $level->name }}</strong>
                            </td>

                            <td>
                                ₱{{ number_format($level->fee, 2) }}
                            </td>

                            <td>
                                {{ $level->validity_months }} months
                            </td>

                            <td>
                                {{ $level->benefits ?: 'No benefits listed' }}
                            </td>

                            <td>
                                @if ($level->is_active)
                                    <span class="badge">Active</span>
                                @else
                                    <span class="badge badge-inactive">Inactive</span>
                                @endif
                            </td>

                            <td>
                                <div class="actions">
                                    <a
                                        href="{{ route('levels.edit', $level) }}"
                                        class="btn btn-secondary"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('levels.destroy', $level) }}"
                                        method="POST"
                                        onsubmit="return confirm('Delete this membership level?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No membership levels have been added yet.</p>

            <a href="{{ route('levels.create') }}" class="btn">
                Add Your First Level
            </a>
        @endif
    </div>
@endsection