#! /bin/sh
protoc --proto_path=examples/proto \
  --php_out=examples/php \
  --grpc_out=examples/php \
  --plugin=protoc-gen-grpc=/home/vagrant/grpc/bins/opt/grpc_php_plugin \
  ./examples/proto/hello.proto