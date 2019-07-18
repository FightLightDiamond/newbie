# API

## Setup

### guzzlehttp
```
 composer require guzzlehttp/guzzle
```

### use

```angular2html
    $route = route('user.find', ['id' => 1]);
    $client = new \GuzzleHttp\Client();
    $response = $client->request('GET', $route);
    
    $response->getStatusCode();
    $response->getHeaderLine('content-type');
    $body = $response->getBody(); 
    $data = json_decode($body, true);
```

### Exercise

Lấy 5 user có id > 10 và <90, không lai
sắp xếp theo email theo chiều giảm dần, rồi tới name theo chiều tăng dần

Lấy tất cả email của user

lấy 1 name của user có email có từ "on"