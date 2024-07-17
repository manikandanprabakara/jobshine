<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidate Search</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
</head>
<style>
    .header-logo {
        display: flex;
        align-items: flex-end;
    }

    .header-logo img {
        max-height: 50px;
        margin-right: 10px;
    }
</style>

<body>
    <div class="container mt-5">
        <div class="header-logo">
            <img src="{{url('/images/shine-logo.png')}}" alt="Logo" />
            <h2>Candidate Search</h2>
        </div>

        <div class="card mb-4">
            <form id="filter-form" onsubmit="return false;">
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <input type="text" id="search" class="form-control" placeholder="Search by name ">
                        </div>
                        <div class="form-group col-md-3">
                            <input type="text" id="job_title" class="form-control" placeholder="Search by  job title">
                        </div>
                        <div class="form-group col-md-3">

                            <input type="text" id="job_category" class="form-control" placeholder="Job category">

                        </div>
                        <div class="form-group col-md-3">
                            <select id="visa_category" class="form-control">
                                <option value="">Select Visa Category</option>
                                @foreach($visaCategories as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <input type="text" id="location" class="form-control" placeholder="Location">
                        </div>
                        <div class="form-group col-md-2">
                            <input type="number" id="age" class="form-control" placeholder="Age">
                        </div>
                        <div class="form-group col-md-2">
                            <input type="number" id="experience" class="form-control" placeholder="Years of Experience">
                        </div>
                        <div class="form-group col-md-2">
                            <input type="number" id="min_salary" class="form-control" placeholder="Min Salary">
                        </div>
                        <div class="form-group col-md-2">
                            <input type="number" id="max_salary" class="form-control" placeholder="Max Salary">
                        </div>
                        <div class="form-group col-md-2">
                            <button id="filterBtn" class="btn btn-primary btn-block">Filter</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <table id="candidates-table" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Job Title</th>
                    <!-- <th>Job Category</th> -->
                    <th>Visa Category</th>
                    <th>Location</th>
                    <th>Age</th>
                    <th>Experience</th>
                    <th>Salary</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>
    <div class="modal fade" id="jobseekerModal" tabindex="-1" role="dialog" aria-labelledby="jobseekerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="jobseekerModalLabel">Jobseeker Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="jobseekerDetails">
                        <p><strong>Name:</strong> <span id="jobseekerName"></span></p>
                        <p><strong>Email:</strong> <span id="jobseekerEmail"></span></p>
                        <p><strong>Phone:</strong> <span id="jobseekerPhone"></span></p>
                        <p><strong>Location:</strong> <span id="jobseekerLocation"></span></p>
                        <p><strong>Eaducation:</strong> <span id="jobseekerEducation"></span></p>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            var table = $('#candidates-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('search.candidates') }}',
                    data: function(d) {
                        d.name = $('#search').val();
                        d.job_title = $('#job_title').val();
                        // d.job_category = $('#job_category').val();
                        d.visa_category = $('#visa_category').val();
                        d.location = $('#location').val();
                        d.age = $('#age').val();
                        d.years_of_experience = $('#experience').val();
                        d.salary_min = $('#min_salary').val();
                        d.salary_max = $('#max_salary').val();
                    }
                },
                columns: [{
                        data: 'full_name',
                        name: 'full_name'
                    },
                    {
                        data: 'job_titles',
                        name: 'job_titles'
                    },
                    // { data: 'job_category', name: 'job_category' },
                    {
                        data: 'visa_category',
                        name: 'visa_category'
                    },
                    {
                        data: 'location',
                        name: 'location'
                    },
                    {
                        data: 'age',
                        name: 'age'
                    },
                    {
                        data: 'work_experience',
                        name: 'work_experience'
                    },
                    {
                        data: 'desired_salary',
                        name: 'desired_salary'
                    },
                    {
                        data: 'actions',
                        name: 'actions'
                    }
                ],
                paging: true
            });

            $('#filter-form input, #filter-form select').on('change', function() {
                table.draw();
            });

            $('#filterBtn').on('click', function() {
                table.draw();
            });



        });
        $('.view-details').on('click', function() {
            var jobseekerId = $(this).data('id');
             alert("Hi");
            // AJAX request to fetch jobseeker details
            $.ajax({
                url: '/jobseekers/' + jobseekerId,
                type: 'GET',
                dataType: 'html',
                success: function(response) {
                    $('#jobseekerDetails').html(response);
                    $('#jobseekerModal').modal('show');  // Ensure modal is initialized properly
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching jobseeker details:', error);
                }
            });
        });

        function onclickssss(id){
            // alert(id);
            $.ajax({
                url: '/jobseekers/' + id,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    // $('#jobseekerDetails').html(response);

                $('#jobseekerName').text(response.full_name ? response.full_name : 'N/A');
                $('#jobseekerEmail').text(response.email ? response.email : 'N/A');
                $('#jobseekerPhone').text(response.phone ? response.phone : 'N/A');
                $('#jobseekerLocation').text(response.location ? response.location : 'N/A');
                $('#jobseekerEducation').text(response.education ? response.education : 'N/A');
                $('#jobseekerResume').attr('href', response.resume_url ? response.resume_url : '#').text('Download Resume');
                $('#jobseekerModal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching jobseeker details:', error);
                }
            });
        }

    </script>
</body>

</html>