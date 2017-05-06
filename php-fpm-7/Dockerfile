FROM php:7-fpm
# Install modules
RUN apt-get update && apt-get install -y \
	libmcrypt-dev  \
	libicu-dev \
	mysql-client \
	wget \
	nodejs \
	npm \
	vim \
	git \
	zip \
#	git-all \
#	google-chrome-stable \
	xvfb \
	libnss3-dev libxi6 libgconf-2-4 \
	&& docker-php-ext-install pdo_mysql \
	&& docker-php-ext-install iconv \
	&& docker-php-ext-install mcrypt \
	&& docker-php-ext-install intl \
	&& docker-php-ext-install opcache \
	&& docker-php-ext-install mbstring \
	&& curl -sS https:\/\/getcomposer.org\/installer | php -- --install-dir=/usr/local/bin --filename=composer
#	&& wget -q -O - https://dl-ssl.google.com/linux/linux_signing_key.pub | apt-key add - \
#	&& sh -c 'echo "deb [arch=amd64] http://dl.google.com/linux/chrome/deb/ stable main" >> /etc/apt/sources.list.d/google-chrome.list'

#    && cd /tmp \
#    && wget http://download.redis.io/redis-stable.tar.gz \
#    && tar xvzf redis-stable.tar.gz \
#    && cd redis-stable \
#    && make \
#    && cp src/redis-cli /usr/local/bin/ \
#    && chmod 755 /usr/local/bin/redis-cli
#    && apt-get install -y nodejs \
#    && apt-get install -y npm

CMD ["php-fpm"]