@extends('layouts.app')

@section('title', 'Create Post (AJAX)')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create Post (AJAX)</div>

                    <div class="card-body">
                        <form id="ajax-post-form" action="{{ route('posts.ajaxStore') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                                <div class="invalid-feedback" id="title-error"></div>
                            </div>

                            <div class="mb-3">
                                <label for="content" class="form-label">Content</label>
                                <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
                                <div class="invalid-feedback" id="content-error"></div>
                            </div>

                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>

                        <div id="success-message" class="alert alert-success mt-3 d-none"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@push('scripts')
<script>
$(document).ready(function() {
    $('#ajax-post-form').on('submit', function(e) {
        e.preventDefault();

        // Reset previous states
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').text('');
        $('#success-message').addClass('d-none').removeClass('alert-danger');

        // Get form data
        var formData = new FormData(this);

        // Make AJAX request
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            dataType: 'json', // Explicitly expect JSON response
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json' // Ensure server knows we want JSON
            },
            success: function(response) {
                // Format the created date
                var createdAt = new Date(response.post.created_at);
                var formattedDate = createdAt.toLocaleDateString() + ' ' + createdAt.toLocaleTimeString();

                // Build success message HTML
                var messageHtml = `
                    <h5>${response.message}</h5>
                    <div class="mt-2">
                        <p><strong>Title:</strong> ${response.post.title}</p>
                        <p><strong>Created:</strong> ${formattedDate}</p>
                        <p><strong>ID:</strong> ${response.post.id}</p>
                    </div>
                `;

                // Display the message
                $('#success-message')
                    .removeClass('d-none')
                    .html(messageHtml);

                // Reset the form
                $('#ajax-post-form')[0].reset();
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    // Handle validation errors
                    var errors = xhr.responseJSON.errors;
                    for (var field in errors) {
                        $('#' + field).addClass('is-invalid');
                        $('#' + field + '-error').text(errors[field][0]);
                    }
                } else {
                    // Handle other errors
                    console.error('Error:', xhr.responseText);
                    $('#success-message')
                        .removeClass('d-none')
                        .addClass('alert-danger')
                        .text('An error occurred. Please try again.');
                }
            }
        });
    });
});
</script>
@endpush
@endsection
