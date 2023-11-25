<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Analysis Tool</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-image: url(image.jpg);
            background-repeat: no-repeat;
            background-size: cover;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }

        header {
            background-color: #0bbeef;
            color: #fff;
            padding: 1em;
            text-align: center;
            font-size: 18px;
        }

        main {
            color: rgb(3, 3, 3);
            padding: 20px;

            margin-top: 1%;
            font-size: 25px;
        }

        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 1em;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .table {
            color: rgb(3, 3, 3);
            backdrop-filter: blur(8px);
            z-index: 2;
            background: rgba(255, 255, 255, 0.9);
        }

        .login {
            font-style: bold;
            font-size: 30px;
            margin-left: 90%;
        }

        #companies {
            margin-top: 0px;
        }

        .table th {
            cursor: pointer;
            position: relative;
        }

        .table th::after {

            display: inline-block;
            vertical-align: middle;
            margin-left: 5px;
            width: 0;
            height: 0;

        }

        .table th.asc::after {
            content: '';
            border-width: 0 4px 4px 4px;
            border-color: transparent transparent #000 transparent;
        }

        .table th.desc::after {
            content: '';
            border-width: 4px 4px 0 4px;
            border-color: #000 transparent transparent transparent;
        }

        .table th:hover {
            text-decoration: underline;
            color: #e8a280;
        }

        .welcome {
            display: flex;
            align-items: center;
            font-size: 50px;
            height: 100px;
            background-color: #0bbeef;
            font-weight: bold;
            margin: auto;

        }
    </style>
    <link rel="stylesheet" href="https://pyscript.net/latest/pyscript.css" />
    <link rel="stylesheet" href="./assets/css/examples.css" />
    <script defer src="https://pyscript.net/latest/pyscript.js"></script>
</head>

<body>
    <?php
    session_start();
    if (isset($_SESSION['username'])) {
        echo "<h1 class=\"welcome mb-4\">Welcome " . $_SESSION['username'] . "</h1>";
    } else {
        header('Location: Login.php');
    }
    ?>


    <main>
        <div class="login">
            <a href="logout.php">Logout</a>
        </div>
        <div class="container">
            <h1 class="mb-4">Stock Analysis Tool</h1>

            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link active" id="companies-tab" data-toggle="tab" href="#companies">Companies</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="charts-tab" data-toggle="tab" href="#charts">Charts</a>
                </li>
                <li class="nav-item">

                </li>
            </ul>
            <div class="tab-content mt-3">
                <div class="tab-pane fade show active" id="companies">
                    <h2>Companies</h2>
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="searchInput">Search by Name:</label>
                            <input type="text" class="form-control" id="searchInput" name="name">
                        </div>
                        <input class="btn btn-primary" type="submit" name="submit" value="Search">
                    </form>

                    <?php
                    $conn = mysqli_connect("localhost", "root", "", "stock_analysis");

                    if (isset($_POST['submit'])) {

                        $name = mysqli_real_escape_string($conn, $_POST["name"]);

                        $query = "SELECT * FROM `companies` WHERE name LIKE '%$name%'";
                        $res = mysqli_query($conn, $query);
                        $table = 'table';
                        if ($res) {
                            if (mysqli_num_rows($res) > 0) {
                                echo "<table class=\"$table\">
                        <thead class=\"thead-dark\">
                            <tr>
                            <th id=\"name-header\">Name</th>
                            <th id=\"volume-header\">Volume</th>
                            <th id=\"price-header\">Price</th>
                            <th id=\"market-cap-header\">Market Cap</th>
                            <th id=\"52-week-low\">52 Week Low</th>
                            <th id=\"52-week-high\">52 Week High</th>
                            </tr>
                        </thead>
                        <tbody>";

                                while ($row = mysqli_fetch_assoc($res)) {
                                    echo "<tr><td>" . $row["name"] . "</td><td>" .
                                        $row["volume"] . "</td>";
                                    echo "</td><td>";
                                    echo $row["price"];
                                    echo "   ";
                                    echo "</td><td>";
                                    echo $row["market_cap"];
                                    echo "   ";
                                    echo "</td><td>";
                                    echo $row["52_week_low"];
                                    echo "   ";
                                    echo "</td><td>";
                                    echo $row["52_week_high"];
                                    echo "   ";
                                    echo "</td></tr>";
                                }

                                echo "</tbody></table>";
                            } else {
                                echo "Data not found";
                            }
                        } else {
                            echo "Query failed: " . mysqli_error($conn);
                        }

                        mysqli_close($conn);
                    }
                    ?>

                </div>
                <div class="tab-pane fade" id="charts">
                    <h2>Charts</h2>
                    <title>Company Charts</title>
                    <script type="py" terminal>
                    pip install Flask requests
                        # Import necessary libraries
from flask import Flask, render_template, request
import requests

# Initialize Flask app
app = Flask(__name__)

# Function to get stock data from an API (e.g., Alpha Vantage)
def get_stock_data(symbol):
    api_key = 'YOUR_API_KEY'  # Replace with your actual API key
    base_url = f'https://www.alphavantage.co/query'
    function = 'TIME_SERIES_INTRADAY'
    interval = '1min'

    # Make a request to the API
    response = requests.get(
        f'{base_url}?function={function}&symbol={symbol}&interval={interval}&apikey={api_key}'
    )

    # Parse the response
    data = response.json()
    time_series_data = data.get('Time Series (1min)', {})
    
    # Extract the latest stock data
    latest_data = list(time_series_data.values())[0]
    
    return latest_data

# Route for the home page
@app.route('/', methods=['GET', 'POST'])
def home():
    if request.method == 'POST':
        symbol = request.form['symbol']
        stock_data = get_stock_data(symbol)
        return render_template('home.html', symbol=symbol, stock_data=stock_data)
    return render_template('home.html')

if __name__ == '__main__':
    app.run(debug=True)

                     </script>
                    <h1>Stock Market Web App</h1>

                    <form method="post" action="/">
                        <label for="symbol">Enter Stock Symbol:</label>
                        <input type="text" id="symbol" name="symbol" required>
                        <button type="submit">Get Stock Data</button>
                    </form>

                    {% if symbol %}
                    <h2>Stock Data for {{ symbol }}</h2>
                    <p>Open: {{ stock_data['1. open'] }}</p>
                    <p>High: {{ stock_data['2. high'] }}</p>
                    <p>Low: {{ stock_data['3. low'] }}</p>
                    <p>Close: {{ stock_data['4. close'] }}</p>
                    <p>Volume: {{ stock_data['5. volume'] }}</p>
                    {% endif %}
                </div>
            </div>
            <thead>
                </tr>
                </tbody>
            </thead>
            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const table = document.querySelector(".table");
                    let isAscending = true;

                    function sortTable(columnIndex) {
                        const rows = Array.from(table.querySelectorAll("tbody tr"));

                        rows.sort((rowA, rowB) => {
                            const cellA = rowA.cells[columnIndex].textContent.trim();
                            const cellB = rowB.cells[columnIndex].textContent.trim();

                            if (!isNaN(cellA) && !isNaN(cellB)) {
                                return isAscending ? cellA - cellB : cellB - cellA;
                            } else {
                                return isAscending ? cellA.localeCompare(cellB) : cellB.localeCompare(cellA);
                            }
                        });

                        rows.forEach(row => table.querySelector("tbody").appendChild(row));
                        isAscending = !isAscending;
                    }

                    document.getElementById("name-header").addEventListener("click", function() {
                        sortTable(0);
                    });

                    document.getElementById("volume-header").addEventListener("click", function() {
                        sortTable(1);
                    });

                    document.getElementById("price-header").addEventListener("click", function() {
                        sortTable(2);
                    });

                    document.getElementById("market-cap-header").addEventListener("click", function() {
                        sortTable(3);
                    });
                    document.getElementById("52-week-low").addEventListener("click", function() {
                        sortTable(4);
                    });
                    document.getElementById("52-week-high").addEventListener("click", function() {
                        sortTable(5);
                    });
                });
            </script>

</body>

</html>
