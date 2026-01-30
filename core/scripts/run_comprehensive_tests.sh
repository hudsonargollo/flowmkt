#!/bin/bash

###############################################################################
# Comprehensive Test Suite Runner
# 
# This script runs all unit tests, property tests, and integration tests
# for the FlowMkt rebranding and localization project.
#
# Usage: ./core/scripts/run_comprehensive_tests.sh
###############################################################################

set -e  # Exit on error

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Test counters
TOTAL_TESTS=0
PASSED_TESTS=0
FAILED_TESTS=0

echo ""
echo "╔════════════════════════════════════════════════════════════════╗"
echo "║         FlowMkt Comprehensive Test Suite Runner               ║"
echo "╚════════════════════════════════════════════════════════════════╝"
echo ""

# Change to core directory
cd "$(dirname "$0")/.."

# Check if PHPUnit is available
if [ ! -f "vendor/bin/phpunit" ]; then
    echo -e "${RED}❌ Error: PHPUnit not found. Please run 'composer install' first.${NC}"
    exit 1
fi

# Check if .env file exists
if [ ! -f ".env" ]; then
    echo -e "${YELLOW}⚠️  Warning: .env file not found. Copying from .env.example...${NC}"
    cp .env.example .env
    php artisan key:generate
fi

echo -e "${BLUE}📋 Test Suite Overview:${NC}"
echo "   • Unit Tests: Basic functionality and configuration tests"
echo "   • Property Tests: Universal correctness properties"
echo "   • Integration Tests: Complete user workflows"
echo ""

###############################################################################
# 1. Run Unit Tests
###############################################################################

echo -e "${BLUE}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo -e "${BLUE}1. Running Unit Tests${NC}"
echo -e "${BLUE}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo ""

if ./vendor/bin/phpunit --testsuite Unit --colors=always; then
    echo -e "${GREEN}✅ Unit tests passed${NC}"
    PASSED_TESTS=$((PASSED_TESTS + 1))
else
    echo -e "${RED}❌ Unit tests failed${NC}"
    FAILED_TESTS=$((FAILED_TESTS + 1))
fi
TOTAL_TESTS=$((TOTAL_TESTS + 1))
echo ""

###############################################################################
# 2. Run Property-Based Tests
###############################################################################

echo -e "${BLUE}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo -e "${BLUE}2. Running Property-Based Tests${NC}"
echo -e "${BLUE}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo ""

if ./vendor/bin/phpunit --testsuite Property --colors=always; then
    echo -e "${GREEN}✅ Property tests passed${NC}"
    PASSED_TESTS=$((PASSED_TESTS + 1))
else
    echo -e "${RED}❌ Property tests failed${NC}"
    FAILED_TESTS=$((FAILED_TESTS + 1))
fi
TOTAL_TESTS=$((TOTAL_TESTS + 1))
echo ""

###############################################################################
# 3. Run Integration Tests
###############################################################################

echo -e "${BLUE}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo -e "${BLUE}3. Running Integration Tests${NC}"
echo -e "${BLUE}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo ""

if ./vendor/bin/phpunit --testsuite Feature --colors=always; then
    echo -e "${GREEN}✅ Integration tests passed${NC}"
    PASSED_TESTS=$((PASSED_TESTS + 1))
else
    echo -e "${RED}❌ Integration tests failed${NC}"
    FAILED_TESTS=$((FAILED_TESTS + 1))
fi
TOTAL_TESTS=$((TOTAL_TESTS + 1))
echo ""

###############################################################################
# 4. Run All Tests Together
###############################################################################

echo -e "${BLUE}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo -e "${BLUE}4. Running Complete Test Suite${NC}"
echo -e "${BLUE}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo ""

if ./vendor/bin/phpunit --colors=always; then
    echo -e "${GREEN}✅ Complete test suite passed${NC}"
    PASSED_TESTS=$((PASSED_TESTS + 1))
else
    echo -e "${RED}❌ Complete test suite failed${NC}"
    FAILED_TESTS=$((FAILED_TESTS + 1))
fi
TOTAL_TESTS=$((TOTAL_TESTS + 1))
echo ""

###############################################################################
# Test Summary
###############################################################################

echo ""
echo "╔════════════════════════════════════════════════════════════════╗"
echo "║                      TEST SUMMARY                              ║"
echo "╚════════════════════════════════════════════════════════════════╝"
echo ""
echo -e "📊 Results:"
echo -e "   • Total test suites: ${TOTAL_TESTS}"
echo -e "   • ${GREEN}Passed: ${PASSED_TESTS}${NC}"
echo -e "   • ${RED}Failed: ${FAILED_TESTS}${NC}"
echo ""

if [ $FAILED_TESTS -eq 0 ]; then
    echo "╔════════════════════════════════════════════════════════════════╗"
    echo -e "║  ${GREEN}✅ SUCCESS: All test suites passed!${NC}                        ║"
    echo "╚════════════════════════════════════════════════════════════════╝"
    echo ""
    exit 0
else
    echo "╔════════════════════════════════════════════════════════════════╗"
    echo -e "║  ${RED}❌ FAILURE: Some test suites failed${NC}                        ║"
    echo "╚════════════════════════════════════════════════════════════════╝"
    echo ""
    echo -e "${YELLOW}Please review the test output above for details.${NC}"
    echo ""
    exit 1
fi
