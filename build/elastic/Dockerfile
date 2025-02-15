FROM arm64v8/openjdk:8-jre

# Create a user and group for Elasticsearch
RUN groupadd -g 1000 elasticsearch && useradd -u 1000 -g elasticsearch -s /bin/bash -m elasticsearch

# Set environment variables
ENV ELASTIC_VERSION=6.8.23
ENV ES_HOME=/usr/share/elasticsearch

# Install dependencies
RUN apt-get update && apt-get install -y wget unzip && apt-get clean

# Download and extract Elasticsearch
RUN wget https://artifacts.elastic.co/downloads/elasticsearch/elasticsearch-$ELASTIC_VERSION.tar.gz && \
    tar -xzf elasticsearch-$ELASTIC_VERSION.tar.gz && \
    mv elasticsearch-$ELASTIC_VERSION $ES_HOME && \
    rm -rf elasticsearch-$ELASTIC_VERSION.tar.gz

# Set ownership
RUN chown -R elasticsearch:elasticsearch $ES_HOME

# Switch to the Elasticsearch user
USER elasticsearch

# Expose ports and entrypoint
WORKDIR $ES_HOME
EXPOSE 9200 9300
ENTRYPOINT ["./bin/elasticsearch"]
