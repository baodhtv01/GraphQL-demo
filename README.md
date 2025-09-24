# GraphQL Demo với Laravel và Docker

Đây là một ứng dụng demo GraphQL được xây dựng với Laravel và Docker, bao gồm các chức năng cơ bản cho User và Post.

## 🚀 Tính năng

- **GraphQL API** với queries và mutations cho User và Post
- **Docker** setup hoàn chỉnh với MySQL
- **Seeding** dữ liệu mẫu
- **Web interface** để test GraphQL queries
- **GraphiQL** playground tích hợp

## 📋 Yêu cầu

- Docker và Docker Compose
- Git

## 🛠️ Cài đặt

### 1. Clone repository

```bash
git clone <repository-url>
cd GraphQL-demo
```

### 2. Tạo file .env

```bash
cp .env.example .env
```

### 3. Build và chạy container

```bash
docker-compose up -d --build
```

### 4. Cài đặt dependencies

```bash
docker-compose exec app composer install
```

### 5. Tạo application key

```bash
docker-compose exec app php artisan key:generate
```

### 6. Chạy migration và seeder

```bash
docker-compose exec app php artisan migrate
docker-compose exec app php artisan db:seed
```

### 7. Publish GraphQL config

```bash
docker-compose exec app php artisan vendor:publish --provider="Rebing\GraphQL\GraphQLServiceProvider"
```

## 🔧 Sử dụng

### Truy cập ứng dụng

- **Trang chính**: http://localhost:8000
- **GraphQL Demo Interface**: http://localhost:8000/graphql-demo
- **GraphQL Endpoint**: http://localhost:8000/graphql
- **GraphiQL Playground**: http://localhost:8000/graphiql

### 📊 Database Schema

#### Users Table
- id (Primary Key)
- name
- email
- password
- created_at
- updated_at

#### Posts Table
- id (Primary Key)
- title
- content
- user_id (Foreign Key)
- published (Boolean)
- created_at
- updated_at

## 🎯 GraphQL Examples

### Queries

#### 1. Lấy danh sách users với posts

```graphql
query {
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
}
```

#### 2. Lấy một user cụ thể

```graphql
query {
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
}
```

#### 3. Lấy danh sách posts với thông tin user

```graphql
query {
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
}
```

#### 4. Lấy một post cụ thể

```graphql
query {
  post(id: 1) {
    id
    title
    content
    published
    user {
      name
      email
    }
  }
}
```

### Mutations

#### 1. Tạo user mới

```graphql
mutation {
  createUser(
    name: "John Doe"
    email: "john@example.com"
    password: "password123"
  ) {
    id
    name
    email
  }
}
```

#### 2. Cập nhật user

```graphql
mutation {
  updateUser(
    id: 1
    name: "Jane Doe"
    email: "jane@example.com"
  ) {
    id
    name
    email
  }
}
```

#### 3. Tạo post mới

```graphql
mutation {
  createPost(
    title: "My First Post"
    content: "This is my first post content"
    user_id: 1
    published: true
  ) {
    id
    title
    content
    published
    user {
      name
    }
  }
}
```

#### 4. Cập nhật post

```graphql
mutation {
  updatePost(
    id: 1
    title: "Updated Post Title"
    published: false
  ) {
    id
    title
    content
    published
  }
}
```

#### 5. Xóa user

```graphql
mutation {
  deleteUser(id: 1)
}
```

#### 6. Xóa post

```graphql
mutation {
  deletePost(id: 1)
}
```

## 📁 Cấu trúc Project

```
app/
├── GraphQL/
│   ├── Types/
│   │   ├── UserType.php
│   │   └── PostType.php
│   ├── Queries/
│   │   ├── UsersQuery.php
│   │   ├── UserQuery.php
│   │   ├── PostsQuery.php
│   │   └── PostQuery.php
│   └── Mutations/
│       ├── CreateUserMutation.php
│       ├── UpdateUserMutation.php
│       ├── DeleteUserMutation.php
│       ├── CreatePostMutation.php
│       ├── UpdatePostMutation.php
│       └── DeletePostMutation.php
├── Models/
│   ├── User.php
│   └── Post.php
database/
├── migrations/
│   ├── create_users_table.php
│   └── create_posts_table.php
├── factories/
│   ├── UserFactory.php
│   └── PostFactory.php
└── seeders/
    └── DatabaseSeeder.php
```

## 🔍 Testing

### Sử dụng GraphiQL

1. Truy cập http://localhost:8000/graphiql
2. Nhập queries hoặc mutations vào editor
3. Nhấn "Execute Query" để chạy

### Sử dụng Custom Demo Interface

1. Truy cập http://localhost:8000/graphql-demo
2. Sử dụng các examples có sẵn hoặc tự viết queries
3. Nhấn "Thực hiện Query" để test

### Sử dụng curl

```bash
curl -X POST http://localhost:8000/graphql \
  -H "Content-Type: application/json" \
  -d '{"query": "{ users { id name email } }"}'
```

## 🐛 Troubleshooting

### 1. Container không start

```bash
docker-compose down
docker-compose up -d --build
```

### 2. Permission errors

```bash
docker-compose exec app chown -R www-data:www-data /var/www
docker-compose exec app chmod -R 755 /var/www/storage
```

### 3. Database connection issues

Kiểm tra file `.env` và đảm bảo database settings đúng:

```
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel_graphql
DB_USERNAME=laravel
DB_PASSWORD=password
```

## 📚 Tài liệu tham khảo

- [Laravel GraphQL](https://github.com/rebing/graphql-laravel)
- [GraphQL Documentation](https://graphql.org/learn/)
- [Docker Documentation](https://docs.docker.com/)

## 🤝 Contributing

1. Fork project
2. Tạo feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Mở Pull Request

## 📄 License

Distributed under the MIT License. See `LICENSE` for more information.

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
