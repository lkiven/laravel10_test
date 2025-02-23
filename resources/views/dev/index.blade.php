@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>SQL Executor</h1>
        <form id="sqlForm">
            <textarea name="sql" id="sql" class="form-control" rows="5"></textarea>
            <button type="button" id="executeButton" class="btn btn-primary">Execute</button>
            <button type="button" id="exportExcelButton" class="btn btn-success">Export Excel</button>
            <button type="button" id="exportJsonButton" class="btn btn-info">Export Json</button>
        </form>
        <div id="resultTable" class="mt-4"></div>
        <div id="errorMessage" class="mt-4 text-danger"></div>
    </div>

    <script>
        document.getElementById('executeButton').addEventListener('click', function () {
            const sql = document.getElementById('sql').value;
            fetch("{{ route('dev.execute') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ sql: sql })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        document.getElementById('errorMessage').innerHTML = data.error;
                        document.getElementById('resultTable').innerHTML = '';
                    } else {
                        document.getElementById('errorMessage').innerHTML = '';
                        let table = '<table class="table table-striped">';
                        if (data.results.length > 0) {
                            const headers = Object.keys(data.results[0]);
                            table += '<thead><tr>';
                            headers.forEach(header => {
                                table += `<th>${header}</th>`;
                            });
                            table += '</tr></thead><tbody>';
                            data.results.forEach(row => {
                                table += '<tr>';
                                headers.forEach(header => {
                                    table += `<td>${row[header]}</td>`;
                                });
                                table += '</tr>';
                            });
                            table += '</tbody>';
                        }
                        table += '</table>';
                        document.getElementById('resultTable').innerHTML = table;
                    }
                });
        });

        document.getElementById('exportExcelButton').addEventListener('click', function () {
            const sql = document.getElementById('sql').value;
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = "{{ route('dev.export-excel') }}";
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'sql';
            input.value = sql;
            form.appendChild(input);
            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = '{{ csrf_token() }}';
            form.appendChild(csrf);
            document.body.appendChild(form);
            form.submit();
        });

        document.getElementById('exportJsonButton').addEventListener('click', function () {
            const sql = document.getElementById('sql').value;
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = "{{ route('dev.export-json') }}";
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'sql';
            input.value = sql;
            form.appendChild(input);
            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = '{{ csrf_token() }}';
            form.appendChild(csrf);
            document.body.appendChild(form);
            form.submit();
        });
    </script>
@endsection