require "json"
require "net/http"
require "uri"

Jekyll::Hooks.register :site, :post_read do |site|
  begin
    if site.config['packagist_stats_url']
      puts 'Starting to fetch packagist stats'
      uri = URI.parse(site.config['packagist_stats_url'])
      http = Net::HTTP.new(uri.host, uri.port)
      http.use_ssl = true
      request = Net::HTTP::Get.new(uri.path)
      response = http.request(request)
      site.data['packagist_stats'] = JSON.parse(response.body)
      puts 'Suceeded to fetch packagist stats'
    end
  rescue => e
    puts "Failed to fetch packagist stats; #{e.message}"
  end
end
