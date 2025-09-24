<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GraphQL Demo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .container {
            margin: 20px 0;
        }
        textarea {
            width: 100%;
            height: 200px;
            font-family: monospace;
        }
        button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 5px;
        }
        button:hover {
            background-color: #0056b3;
        }
        .result {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            margin-top: 20px;
        }
        .examples {
            background-color: #e9ecef;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        pre {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 3px;
            overflow-x: auto;
        }
    </style>
</head>
<body>
    <h1>GraphQL Demo - Laravel</h1>

    <div class="examples">
        <h3>Ví dụ Queries & Mutations:</h3>

        <h4>1. Lấy danh sách users:</h4>
        <pre>query {
  users(limit: 5) {
    id
    name
    email
    posts {
      id
      title
      published
    }
  }
}</pre>

        <h4>2. Lấy một user:</h4>
        <pre>query {
  user(id: 1) {
    id
    name
    email
    posts {
      id
      title
      content
      published
    }
  }
}</pre>

        <h4>3. Tạo user mới:</h4>
        <pre>mutation {
  createUser(name: "John Doe", email: "john@example.com", password: "password123") {
    id
    name
    email
  }
}</pre>

        <h4>4. Tạo post mới:</h4>
        <pre>mutation {
  createPost(title: "My First Post", content: "This is my first post content", user_id: 1, published: true) {
    id
    title
    content
    published
    user {
      name
    }
  }
}</pre>

        <h4>5. Lấy danh sách posts:</h4>
        <pre>query {
  posts(limit: 10, published: true) {
    id
    title
    content
    published
    user {
      name
      email
    }
  }
}</pre>
    </div>

    <div class="container">
        <h3>GraphQL Query/Mutation:</h3>
        <textarea id="query" placeholder="Nhập GraphQL query hoặc mutation của bạn...">query {
  users(limit: 5) {
    id
    name
    email
    posts {
      id
      title
      published
    }
  }
}</textarea>

        <div>
            <button onclick="executeQuery()">Thực hiện Query</button>
            <button onclick="clearQuery()">Xóa</button>
        </div>

        <div class="result" id="result">
            <strong>Kết quả sẽ hiển thị ở đây...</strong>
        </div>
    </div>

    <script>
        async function executeQuery() {
            const query = document.getElementById('query').value;
            const resultDiv = document.getElementById('result');

            if (!query.trim()) {
                resultDiv.innerHTML = '<strong style="color: red;">Vui lòng nhập một query!</strong>';
                return;
            }

            resultDiv.innerHTML = '<strong>Đang thực hiện...</strong>';

            try {
                const response = await fetch('/graphql', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        query: query
                    })
                });

                const data = await response.json();
                resultDiv.innerHTML = '<pre>' + JSON.stringify(data, null, 2) + '</pre>';
            } catch (error) {
                resultDiv.innerHTML = '<strong style="color: red;">Lỗi: ' + error.message + '</strong>';
            }
        }

        function clearQuery() {
            document.getElementById('query').value = '';
            document.getElementById('result').innerHTML = '<strong>Kết quả sẽ hiển thị ở đây...</strong>';
        }
    </script>
</body>
</html>
