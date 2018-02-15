require "json"
require "net/http"
require "uri"

Jekyll::Hooks.register :site, :post_read do |site|
  begin
    site.data['changelog_events'] = []
    if site.config['github_repo']
      puts 'Starting to fetch changelog events'
      commits_url = "https://api.github.com/repos/#{site.config['github_repo']}/commits?per_page=100&page=1"
      while commits_url
        begin
          uri = URI(commits_url)
          response = Net::HTTP.get_response(uri)
          site.data['changelog_events'] += JSON.parse(response.body).map do |commit|
            {
              'id' => commit['sha'],
              'date' => commit['commit']['author']['date'],
              'message' => commit['commit']['message'],
            }
          end
          commits_url = response["link"].split(',').select { |link|
            link.include? 'rel="next"'
          }.map { |link| link[/<(.*?)>/m, 1] }.shift
        rescue => e
          puts e.inspect
          puts e.backtrace
          commits_url = nil
        end
      end
      puts 'Suceeded to fetch changelog events'
    end
  rescue => e
    puts "Failed to fetch changelog events; #{e.message}"
  end
end
