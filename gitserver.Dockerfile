FROM node:alpine
RUN apk add --no-cache tini git \
    && yarn global add git-http-server \
    && adduser -D -g git git

USER git
WORKDIR /home/git
RUN git config --global user.name "Lim Jun Wei Fabian" \
    && git config --global user.email "2103295@sit.singaporetech.edu.sg" \
    && git init --bare repository.git
ENTRYPOINT ["tini", "--", "git-http-server", "-p", "3000", "/home/git"]