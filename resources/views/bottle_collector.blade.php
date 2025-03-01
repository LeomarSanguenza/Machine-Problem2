<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bottle Collector</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Bottle Collector Earnings Calculator</h2>
    <form id="collectorForm">
        <div class="mb-3">
            <label for="daily_expenses" class="form-label">Daily Expenses:</label>
            <input type="number" step="0.01" name="daily_expenses" id="daily_expenses" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="expeditions" class="form-label">Expeditions (one per line, format: "hours path price"):</label>
            <textarea name="expeditions" placeholder="Example: 8 ABIBAS 25" id="expeditions" class="form-control" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Calculate</button>
    </form>
    <div class="mt-3" id="result"></div>
</div>

<script>
document.getElementById('collectorForm').addEventListener('submit', function(event) {
    event.preventDefault();
    let daily_expenses = document.getElementById('daily_expenses').value;
    let expeditions = document.getElementById('expeditions').value.split("\n").map(e => e.trim()).filter(e => e);

    fetch("{{ route('calculate.earnings') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ daily_expenses, expeditions })
    })
    .then(response => response.json())
    .then(data => document.getElementById("result").innerHTML = `<div class="alert alert-info">${data.result}</div>`)
    .catch(error => console.error("Error:", error));
});
</script>
</body>
</html>
