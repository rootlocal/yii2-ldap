PHP = $$(which php)
GIT = $$(which git)
COMPOSER = $$(which composer)
COMPOSER_FLAGS ?=
RM ?= rm -f
YII = $(PHP) vendor/bin/yii
codecept ?= vendor/bin/codecept
codecept_flags ?= --coverage --xml --html --coverage-text

.PHONY: all clean test serve assets-clean composer-update runtime-clean

all:
	@echo "*** run all ***"

assets-clean:
	@echo "*** run assets-clean ***"
	-$(RM) -r ./tests/web/assets/*

runtime-clean:
	@echo "*** run runtime-clean ***"
	-$(RM) -r ./tests/runtime/*

clean: assets-clean runtime-clean
	@echo "*** run clean ***"

composer-update:
	@echo "*** run composer-update ***"
	-COMPOSER_MEMORY_LIMIT=-1 $(COMPOSER) $(COMPOSER_FLAGS) update

serve:
	@echo "*** run serve ***"
	@$(PHP) -v
	-chmod -R 0777 tests/runtime
	-chmod -R 0777 tests/web/assets
	-sh tests/bin/php_serve.sh

start-ldap:
	-@echo "*** run Start LDAP ***"
	-sh tests/bin/slapd_start.sh

test:
	@echo "*** run test ***"
	$(codecept) build
	$(codecept) run $(codecept_flags)