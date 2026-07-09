<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-bold fs-4">My Profile</h2>
    </x-slot>

    <div class="container py-4">

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('applicant.profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Phone Number</label>
                    <input type="text" name="phone" value="{{ old('phone', $profile->phone) }}" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Date of Birth</label>
                    <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $profile->date_of_birth?->format('Y-m-d')) }}" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Gender</label>
                    <select name="gender" class="form-select">
                        <option value="">-- Select --</option>
                        <option value="male" {{ old('gender', $profile->gender) === 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender', $profile->gender) === 'female' ? 'selected' : '' }}>Female</option>
                        <option value="other" {{ old('gender', $profile->gender) === 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">National ID</label>
                    <input type="text" name="national_id" value="{{ old('national_id', $profile->national_id) }}" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Institution</label>
                    <input type="text" name="institution" value="{{ old('institution', $profile->institution) }}" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Course of Study</label>
                    <input type="text" name="course_of_study" value="{{ old('course_of_study', $profile->course_of_study) }}" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Education Level</label>
                    <select name="education_level" class="form-select">
                        <option value="">-- Select --</option>
                        <option value="high_school" {{ old('education_level', $profile->education_level) === 'high_school' ? 'selected' : '' }}>High School</option>
                        <option value="undergraduate" {{ old('education_level', $profile->education_level) === 'undergraduate' ? 'selected' : '' }}>Undergraduate</option>
                        <option value="postgraduate" {{ old('education_level', $profile->education_level) === 'postgraduate' ? 'selected' : '' }}>Postgraduate</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Address</label>
                    <textarea name="address" class="form-control" rows="2">{{ old('address', $profile->address) }}</textarea>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Save Profile</button>
        </form>

    </div>
</x-app-layout>