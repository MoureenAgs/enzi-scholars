<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-bold fs-4">Available Scholarships</h2>
    </x-slot>

    <div class="container py-4">

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
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

        @forelse ($openScholarships as $scholarship)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $scholarship->title }}</h5>
                    <p class="card-text">{{ Str::limit($scholarship->description, 150) }}</p>
                    <p class="text-muted mb-2">
                        <strong>Deadline:</strong> {{ $scholarship->application_deadline->format('d M Y') }}
                    </p>

                    @if ($scholarship->application_form_path)
                        <a href="{{ route('scholarships.downloadForm', $scholarship) }}" class="btn btn-outline-dark btn-sm mb-2">
                            📄 Download Application Form
                        </a>
                        <br>
                    @endif

                    @if (in_array($scholarship->id, $appliedScholarshipIds))
                        <span class="badge bg-secondary">Already Applied</span>
                    @else
                        <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#applyForm{{ $scholarship->id }}">
                            Apply Now
                        </button>

                        <div class="collapse mt-3" id="applyForm{{ $scholarship->id }}">
                            <div class="border rounded p-3" style="background-color: #FAF7F1;">

                                <div class="mb-3 pb-2 border-bottom">
                                    <strong style="color: #2C7A78;">Upload Documents to Process Application</strong>
                                    <div class="text-muted small mt-1">
                                        Please select each file below, then click <strong>Submit Application</strong> once all documents are ready.
                                        All 5 documents are required.
                                        @if ($scholarship->application_form_path)
                                            Don't forget to download the application form above, fill it out, and upload it here.
                                        @endif
                                    </div>
                                </div>

                                <form action="{{ route('applicant.applications.store') }}" method="POST" enctype="multipart/form-data" id="form{{ $scholarship->id }}" onsubmit="return validateAllFiles('{{ $scholarship->id }}')">
                                    @csrf
                                    <input type="hidden" name="scholarship_id" value="{{ $scholarship->id }}">

                                    <div class="row g-3">
                                        @php
                                            $docFields = [
                                                'application_form' => ['Application Form', 'PDF, JPG or PNG', ['pdf', 'jpg', 'jpeg', 'png']],
                                                'birth_certificate' => ['Birth Certificate', 'PDF, JPG or PNG', ['pdf', 'jpg', 'jpeg', 'png']],
                                                'acceptance_letter' => ['Letter of Acceptance', 'PDF, JPG or PNG', ['pdf', 'jpg', 'jpeg', 'png']],
                                                'recommendation_letter' => ['Recommendation Letter', 'PDF, JPG or PNG', ['pdf', 'jpg', 'jpeg', 'png']],
                                                'passport_photo' => ['Passport Photo', 'JPG or PNG only', ['jpg', 'jpeg', 'png']],
                                            ];
                                        @endphp

                                        @foreach ($docFields as $fieldName => [$label, $hint, $allowedExt])
                                            <div class="col-md-6">
                                                <div class="position-relative">
                                                    <label for="{{ $fieldName }}_{{ $scholarship->id }}" class="upload-box w-100" id="box_{{ $fieldName }}_{{ $scholarship->id }}">
                                                        <div class="upload-icon">⬆</div>
                                                        <div class="fw-semibold small">{{ $label }} <span class="text-danger">*</span></div>
                                                        <div class="text-muted small file-chosen-label" id="label_{{ $fieldName }}_{{ $scholarship->id }}">Select file to upload</div>
                                                        <div class="text-muted" style="font-size: 0.7rem;">{{ $hint }}</div>
                                                    </label>
                                                    <button type="button" class="btn-close position-absolute" style="top: 8px; right: 8px; display: none;"
                                                            id="clear_{{ $fieldName }}_{{ $scholarship->id }}"
                                                            aria-label="Remove file"
                                                            onclick="clearFile('{{ $fieldName }}_{{ $scholarship->id }}')"></button>
                                                </div>
                                                <div class="text-danger small mt-1" id="error_{{ $fieldName }}_{{ $scholarship->id }}" style="display: none;"></div>
                                                <input type="file" id="{{ $fieldName }}_{{ $scholarship->id }}" name="{{ $fieldName }}"
                                                       class="visually-hidden upload-input"
                                                       data-allowed="{{ implode(',', $allowedExt) }}"
                                                       required
                                                       onchange="handleFileSelect('{{ $fieldName }}_{{ $scholarship->id }}')">
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="form-check mt-4">
                                        <input class="form-check-input" type="checkbox" required id="confirm{{ $scholarship->id }}">
                                        <label class="form-check-label small" for="confirm{{ $scholarship->id }}">
                                            I confirm that all uploaded documents are accurate and belong to me.
                                        </label>
                                    </div>

                                    <div class="d-flex gap-2 mt-3">
                                        <button type="submit" class="btn text-white" style="background-color: #2C7A78;">
                                            Submit Application
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary"
                                                onclick="cancelApplication('{{ $scholarship->id }}')">
                                            Cancel
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <p class="text-muted">No open scholarships available at this time. Check back later.</p>
        @endforelse

    </div>
</x-app-layout>

<style>
    .upload-box {
        display: block;
        border: 2px dashed #ccc;
        border-radius: 8px;
        background: white;
        padding: 1.25rem 1rem;
        text-align: center;
        cursor: pointer;
        transition: border-color 0.15s ease, background-color 0.15s ease;
    }
    .upload-box:hover {
        border-color: #2C7A78;
        background-color: #f4faf9;
    }
    .upload-box.upload-box-error {
        border-color: #dc3545;
        background-color: #fff5f5;
    }
    .upload-icon {
        font-size: 1.4rem;
        color: #D9A441;
        margin-bottom: 4px;
    }
</style>

<script>
    function getExtension(filename) {
        return filename.split('.').pop().toLowerCase();
    }

    function handleFileSelect(fieldId) {
        const input = document.getElementById(fieldId);
        const label = document.getElementById('label_' + fieldId);
        const clearBtn = document.getElementById('clear_' + fieldId);
        const errorEl = document.getElementById('error_' + fieldId);
        const boxEl = document.getElementById('box_' + fieldId);
        const allowed = input.dataset.allowed.split(',');

        if (!input.files[0]) {
            resetFieldVisual(fieldId);
            return;
        }

        const file = input.files[0];
        const ext = getExtension(file.name);

        if (!allowed.includes(ext)) {
            errorEl.textContent = 'Invalid file type. Allowed: ' + allowed.join(', ').toUpperCase();
            errorEl.style.display = 'block';
            boxEl.classList.add('upload-box-error');
            label.textContent = 'Select file to upload';
            clearBtn.style.display = 'none';
            input.value = '';
            return;
        }

        errorEl.style.display = 'none';
        boxEl.classList.remove('upload-box-error');
        label.textContent = file.name;
        clearBtn.style.display = 'block';
    }

    function resetFieldVisual(fieldId) {
        document.getElementById('label_' + fieldId).textContent = 'Select file to upload';
        document.getElementById('clear_' + fieldId).style.display = 'none';
        document.getElementById('error_' + fieldId).style.display = 'none';
        document.getElementById('box_' + fieldId).classList.remove('upload-box-error');
    }

    function clearFile(fieldId) {
        const input = document.getElementById(fieldId);
        input.value = '';
        resetFieldVisual(fieldId);
    }

    function cancelApplication(scholarshipId) {
        const form = document.getElementById('form' + scholarshipId);
        form.reset();

        form.querySelectorAll('.upload-input').forEach(function (input) {
            resetFieldVisual(input.id);
        });

        const collapseEl = document.getElementById('applyForm' + scholarshipId);
        const bsCollapse = window.bootstrap.Collapse.getOrCreateInstance(collapseEl);
        bsCollapse.hide();
    }

    function validateAllFiles(scholarshipId) {
        const form = document.getElementById('form' + scholarshipId);
        const inputs = form.querySelectorAll('.upload-input');

        for (const input of inputs) {
            if (!input.files[0]) {
                alert('Please upload all required documents before submitting.');
                return false;
            }
        }
        return true;
    }
</script>