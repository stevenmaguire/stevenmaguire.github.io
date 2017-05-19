module Jekyll
  module Numbers
    def comma_delimited(number)
      begin
        number = number.to_s.reverse.gsub(/(\d{3})(?=\d)/, '\\1,').reverse
      rescue => e
        puts e
      end
      number.to_s
    end

    def round_down(number, magnitude = 10)
      begin
        number = (number / magnitude.to_f).floor * magnitude
      rescue => e
        puts e
      end
      number
    end
  end
end

Liquid::Template.register_filter(Jekyll::Numbers)
