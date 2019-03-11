workflow "validate commit message action" {
  on = "push"
  resolves = ["harmenjanssen/commit-message-validation-action@master"]
}

action "harmenjanssen/commit-message-validation-action@master" {
  uses = "harmenjanssen/commit-message-validation-action@master"
  secrets = ["GITHUB_TOKEN"]
}
