<!DOCTYPE html>
<html>
<head>
    <title>Blog Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .container {
            background-color: #fff;
            margin: 20px;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .blog-title {
            font-size: 24px;
            font-weight: bold;
            margin: 10px 0;
        }

        .blog-description {
            font-size: 16px;
            line-height: 1.6;
            margin: 10px 0;
        }

        .author {
            font-size: 14px;
            color: #666;
        }

        .tags {
            font-size: 14px;
            color: #666;
        }

        .date {
            font-size: 14px;
            color: #666;
        }

        .links {
            margin: 20px 0;
        }

        .link-button {
            display: inline-block;
            background-color: #007bff;
            color: #fff;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            margin-right: 10px;
            text-decoration: none;
            cursor: pointer;
        }

        .link-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="blog-title">Title: {{$blog->title}}</div>
    <div class="author">Author: {{ $blog->user->name }}</div>
    <div class="tags">Tags: {{ $blog->tags->pluck('name')->implode(', ') }}</div>
    <div class="date">Date: {{ $blog->created_at->format('F j, Y') }}</div>
    <div class="blog-description">
        Description: {{ $blog->description }}
    </div>

    <div class="links">
        <ul>
            @foreach ($blog->links as $link)
                <li><a href="{{ $link->url }}">{{ $link->title }}</a></li>
            @endforeach
        </ul>
    </div>
</div>
</body>
</html>
