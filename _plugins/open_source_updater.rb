Jekyll::Hooks.register :site, :pre_render do |site|
  if site.data['packagist_stats']
    site.collections.each do |collection|
      if collection.first == 'opensource'
        collection[1].docs.each do |doc|
          begin
            if doc.data['language'].downcase == 'php' && doc.data['packagist']
              packagist_data = site.data['packagist_stats']['packages'].select do |package|
                package['package']['name'].downcase == doc.data['packagist'].downcase
              end
              if packagist_data.first
                doc.data['downloads'] = packagist_data.first['package']['downloads']['total']
                doc.data['description'] = packagist_data.first['package']['description']
              end
            end
          rescue; end
        end
      end
    end
  end
end
