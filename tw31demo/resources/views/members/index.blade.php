@extends('layouts.app')

@section('title', 'Members')

@section('content')
    <div class="topbar">
        <div>
            <h1>Members</h1>
            <p>Register, search, and manage membership records.</p>
        </div>

        <a href="{{ route('members.create') }}" class="btn">
            + Register Member
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <form method="GET" action="{{ route('members.index') }}">
            <div class="member-filters">

                <div class="form-group">
                    <label for="search">Search</label>

                    <input
                        type="text"
                        id="search"
                        name="search"
                        value="{{ $search }}"
                        placeholder="Name, email, or membership number"
                    >
                </div>

                <div class="form-group">
                    <label for="category">Category</label>

                    <select id="category" name="category">
                        <option value="">All categories</option>

                        @foreach ($categories as $category)
                            <option
                                value="{{ $category->id }}"
                                @selected($selectedCategory == $category->id)
                            >
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="level">Membership Level</label>

                    <select id="level" name="level">
                        <option value="">All levels</option>

                        @foreach ($levels as $level)
                            <option
                                value="{{ $level->id }}"
                                @selected($selectedLevel == $level->id)
                            >
                                {{ $level->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>

            <button type="submit" class="btn">
                Search
            </button>

            <a href="{{ route('members.index') }}" class="btn btn-secondary">
                Reset
            </a>
        </form>
    </div>

    <div class="card">
        @if ($members->count())
            <table>
                <thead>
                    <tr>
                        <th>Membership Number</th>
                        <th>Member Name</th>
                        <th>Email</th>
                        <th>Category</th>
                        <th>Level</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($members as $member)
                        <tr>
                            <td>
                                <strong>
                                    {{ $member->membership_number }}
                                </strong>
                            </td>

                            <td>
                                {{ $member->first_name }}
                                {{ $member->last_name }}
                            </td>

                            <td>
                                {{ $member->email ?: 'No email' }}
                            </td>

                            <td>
                                {{ $member->category->name }}
                            </td>

                            <td>
                                {{ $member->level->name }}
                            </td>

                            <td>
                                @if ($member->status === 'Active')
                                    <span class="badge">
                                        Active
                                    </span>
                                @else
                                    <span class="badge badge-inactive">
                                        Inactive
                                    </span>
                                @endif
                            </td>

                            <td>
                                <div class="actions">
                                    <a
                                        href="{{ route('members.show', $member) }}"
                                        class="btn"
                                    >
                                        View
                                    </a>

                                    <a
                                        href="{{ route('members.edit', $member) }}"
                                        class="btn btn-secondary"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('members.destroy', $member) }}"
                                        method="POST"
                                        onsubmit="return confirm('Deactivate this member?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-danger"
                                        >
                                            Deactivate
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div style="margin-top: 20px;">
                {{ $members->links() }}
            </div>
        @else
            <p>No members match your search.</p>
        @endif
    </div>

    <style>
        .member-filters {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 16px;
        }

        @media (max-width: 800px) {
            .member-filters {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection