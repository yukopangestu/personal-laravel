#!/bin/bash

# Production Deployment Script for Personal Branding Website

# Exit on error
set -e

# Display help message
if [ "$1" == "-h" ] || [ "$1" == "--help" ]; then
  echo "Usage: ./deploy.sh [options]"
  echo ""
  echo "Options:"
  echo "  -h, --help     Display this help message"
  echo "  -f, --force    Force deployment without confirmation"
  echo ""
  echo "This script deploys the application to production."
  exit 0
fi

# Check if force flag is set
FORCE=false
if [ "$1" == "-f" ] || [ "$1" == "--force" ]; then
  FORCE=true
fi

# Check if git is installed
if ! command -v git &> /dev/null; then
  echo "Error: git is not installed. Please install git and try again."
  exit 1
fi

# Check if docker is installed
if ! command -v docker &> /dev/null; then
  echo "Error: docker is not installed. Please install docker and try again."
  exit 1
fi

# Check if docker-compose is installed
if ! command -v docker-compose &> /dev/null; then
  echo "Error: docker-compose is not installed. Please install docker-compose and try again."
  exit 1
fi

# Check if make is installed
if ! command -v make &> /dev/null; then
  echo "Error: make is not installed. Please install make and try again."
  exit 1
fi

# Check if we're in a git repository
if [ ! -d .git ]; then
  echo "Error: Not a git repository. Please run this script from the root of the git repository."
  exit 1
fi

# Check if there are uncommitted changes
if [ -n "$(git status --porcelain)" ]; then
  echo "Warning: There are uncommitted changes in the repository."
  if [ "$FORCE" != true ]; then
    read -p "Do you want to continue anyway? (y/n) " -n 1 -r
    echo
    if [[ ! $REPLY =~ ^[Yy]$ ]]; then
      echo "Deployment aborted."
      exit 1
    fi
  fi
fi

# Pull latest changes from the repository
echo "Pulling latest changes from the repository..."
git pull

# Deploy to production
echo "Deploying to production..."
make prod

echo "Deployment completed successfully!"
echo "Your application is now running at: http://localhost:4001"
