<?php
// WebGenX - AI-Powered Website Generator
?>

<!-- How to Use Guide -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-dark mb-2">How WebGenX Works</h2>
            <p class="text-muted">Create professional websites in 4 simple steps</p>
        </div>
        <div class="row g-4">
            <div class="col-md-3">
                <div class="text-center position-relative">
                    <div class="step-card h-100 p-4 bg-white rounded-4 shadow-sm border-0 position-relative">
                        <div class="position-absolute top-0 start-50 translate-middle">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 30px; height: 30px; font-size: 14px;">1</div>
                        </div>
                        <div class="feature-icon bg-primary bg-opacity-10 mx-auto mb-3 mt-3" style="width: 70px; height: 70px;">
                            <i class="fas fa-pencil-alt text-primary fs-3"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-2">Describe Website</h6>
                        <p class="text-muted small mb-0">Tell us about your website purpose and content needs</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-center position-relative">
                    <div class="step-card h-100 p-4 bg-white rounded-4 shadow-sm border-0 position-relative">
                        <div class="position-absolute top-0 start-50 translate-middle">
                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 30px; height: 30px; font-size: 14px;">2</div>
                        </div>
                        <div class="feature-icon bg-success bg-opacity-10 mx-auto mb-3 mt-3" style="width: 70px; height: 70px;">
                            <i class="fas fa-palette text-success fs-3"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-2">Choose Style</h6>
                        <p class="text-muted small mb-0">Select website type and design preferences</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-center position-relative">
                    <div class="step-card h-100 p-4 bg-white rounded-4 shadow-sm border-0 position-relative">
                        <div class="position-absolute top-0 start-50 translate-middle">
                            <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 30px; height: 30px; font-size: 14px;">3</div>
                        </div>
                        <div class="feature-icon bg-warning bg-opacity-10 mx-auto mb-3 mt-3" style="width: 70px; height: 70px;">
                            <i class="fas fa-cog text-warning fs-3"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-2">Customize</h6>
                        <p class="text-muted small mb-0">Add colors, fonts, and layout options</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-center position-relative">
                    <div class="step-card h-100 p-4 bg-white rounded-4 shadow-sm border-0 position-relative">
                        <div class="position-absolute top-0 start-50 translate-middle">
                            <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 30px; height: 30px; font-size: 14px;">4</div>
                        </div>
                        <div class="feature-icon bg-info bg-opacity-10 mx-auto mb-3 mt-3" style="width: 70px; height: 70px;">
                            <i class="fas fa-globe text-info fs-3"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-2">Generate & Deploy</h6>
                        <p class="text-muted small mb-0">AI builds your site, ready to publish</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="tool-content">
    <div class="container">

        <!-- Website Generation Form -->
        <div class="tool-card mb-4" id="websiteForm">
            <div class="tool-card-header">
                <h5 class="mb-0 d-flex align-items-center gap-2">
                    <i class="fas fa-magic text-success"></i>
                    Website Details
                </h5>
            </div>
            <div class="tool-card-body">
            
            <form id="webGenForm">
                <div class="row g-4">
                    <!-- Basic Information -->
                    <div class="col-12">
                        <h6 class="fw-bold text-dark mb-3">Basic Information</h6>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="websiteName" class="form-label fw-medium">Website Name *</label>
                        <input type="text" class="form-control" id="websiteName" name="websiteName" required placeholder="My Portfolio">
                    </div>
                    
                    <div class="col-md-6">
                        <label for="websiteType" class="form-label fw-medium">Website Type *</label>
                        <select class="form-select" id="websiteType" name="websiteType" required>
                            <option value="">Select Type</option>
                            <option value="portfolio">Portfolio Website</option>
                            <option value="business">Business Website</option>
                            <option value="blog">Blog Website</option>
                            <option value="landing">Landing Page</option>
                        </select>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="ownerName" class="form-label fw-medium">Owner Name *</label>
                        <input type="text" class="form-control" id="ownerName" name="ownerName" required placeholder="John Doe">
                    </div>
                    
                    <div class="col-md-6">
                        <label for="tagline" class="form-label fw-medium">Tagline</label>
                        <input type="text" class="form-control" id="tagline" name="tagline" placeholder="Full Stack Developer & Designer">
                    </div>
                    
                    <!-- Contact Information -->
                    <div class="col-12 mt-4">
                        <h6 class="fw-bold text-dark mb-3">Contact Information</h6>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="email" class="form-label fw-medium">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="john@example.com">
                    </div>
                    
                    <div class="col-md-6">
                        <label for="phone" class="form-label fw-medium">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="+1 234 567 8900">
                    </div>
                    
                    <div class="col-md-6">
                        <label for="location" class="form-label fw-medium">Location</label>
                        <input type="text" class="form-control" id="location" name="location" placeholder="New York, USA">
                    </div>
                    
                    <div class="col-md-6">
                        <label for="website" class="form-label fw-medium">Existing Website</label>
                        <input type="url" class="form-control" id="website" name="website" placeholder="https://example.com">
                    </div>
                    
                    <!-- About Section -->
                    <div class="col-12 mt-4">
                        <h6 class="fw-bold text-dark mb-3">About Section</h6>
                    </div>
                    
                    <!-- Portfolio/Personal Fields -->
                    <div class="col-12 website-type-fields" data-type="portfolio">
                        <label for="bio" class="form-label fw-medium">Bio/Description</label>
                        <textarea class="form-control" id="bio" name="bio" rows="4" placeholder="Tell us about yourself..."></textarea>
                    </div>
                    
                    <div class="col-12 website-type-fields" data-type="portfolio">
                        <label for="skills" class="form-label fw-medium">Skills (comma-separated)</label>
                        <input type="text" class="form-control" id="skills" name="skills" placeholder="JavaScript, React, Node.js, UI/UX Design">
                    </div>
                    
                    <!-- Business Fields -->
                    <div class="col-12 website-type-fields" data-type="business" style="display: none;">
                        <label for="companyDescription" class="form-label fw-medium">Company Description</label>
                        <textarea class="form-control" id="companyDescription" name="companyDescription" rows="4" placeholder="Describe your company, mission, and values..."></textarea>
                    </div>
                    
                    <div class="col-md-6 website-type-fields" data-type="business" style="display: none;">
                        <label for="industry" class="form-label fw-medium">Industry</label>
                        <input type="text" class="form-control" id="industry" name="industry" placeholder="Technology, Healthcare, Finance, etc.">
                    </div>
                    
                    <div class="col-md-6 website-type-fields" data-type="business" style="display: none;">
                        <label for="foundedYear" class="form-label fw-medium">Founded Year</label>
                        <input type="number" class="form-control" id="foundedYear" name="foundedYear" placeholder="2020" min="1900" max="2025">
                    </div>
                    
                    <div class="col-12 website-type-fields" data-type="business" style="display: none;">
                        <label for="services" class="form-label fw-medium">Services Offered (comma-separated)</label>
                        <input type="text" class="form-control" id="services" name="services" placeholder="Web Development, Digital Marketing, Consulting">
                    </div>
                    
                    <div class="col-md-6 website-type-fields" data-type="business" style="display: none;">
                        <label for="teamSize" class="form-label fw-medium">Team Size</label>
                        <select class="form-select" id="teamSize" name="teamSize">
                            <option value="">Select Team Size</option>
                            <option value="1-5">1-5 employees</option>
                            <option value="6-20">6-20 employees</option>
                            <option value="21-50">21-50 employees</option>
                            <option value="51-100">51-100 employees</option>
                            <option value="100+">100+ employees</option>
                        </select>
                    </div>
                    
                    <div class="col-md-6 website-type-fields" data-type="business" style="display: none;">
                        <label for="businessHours" class="form-label fw-medium">Business Hours</label>
                        <input type="text" class="form-control" id="businessHours" name="businessHours" placeholder="Mon-Fri 9AM-6PM">
                    </div>
                    
                    <!-- Blog Fields -->
                    <div class="col-12 website-type-fields" data-type="blog" style="display: none;">
                        <label for="blogDescription" class="form-label fw-medium">Blog Description</label>
                        <textarea class="form-control" id="blogDescription" name="blogDescription" rows="4" placeholder="Describe what your blog is about..."></textarea>
                    </div>
                    
                    <div class="col-md-6 website-type-fields" data-type="blog" style="display: none;">
                        <label for="authorName" class="form-label fw-medium">Author Name</label>
                        <input type="text" class="form-control" id="authorName" name="authorName" placeholder="John Doe">
                    </div>
                    
                    <div class="col-md-6 website-type-fields" data-type="blog" style="display: none;">
                        <label for="blogNiche" class="form-label fw-medium">Blog Niche</label>
                        <select class="form-select" id="blogNiche" name="blogNiche">
                            <option value="">Select Niche</option>
                            <option value="technology">Technology</option>
                            <option value="lifestyle">Lifestyle</option>
                            <option value="business">Business</option>
                            <option value="health">Health & Fitness</option>
                            <option value="travel">Travel</option>
                            <option value="food">Food & Cooking</option>
                            <option value="fashion">Fashion</option>
                            <option value="education">Education</option>
                            <option value="finance">Finance</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    
                    <div class="col-12 website-type-fields" data-type="blog" style="display: none;">
                        <label for="blogCategories" class="form-label fw-medium">Blog Categories (comma-separated)</label>
                        <input type="text" class="form-control" id="blogCategories" name="blogCategories" placeholder="Web Development, Tutorials, Reviews">
                    </div>
                    
                    <div class="col-md-6 website-type-fields" data-type="blog" style="display: none;">
                        <label for="postFrequency" class="form-label fw-medium">Posting Frequency</label>
                        <select class="form-select" id="postFrequency" name="postFrequency">
                            <option value="">Select Frequency</option>
                            <option value="daily">Daily</option>
                            <option value="weekly">Weekly</option>
                            <option value="biweekly">Bi-weekly</option>
                            <option value="monthly">Monthly</option>
                        </select>
                    </div>
                    
                    <div class="col-md-6 website-type-fields" data-type="blog" style="display: none;">
                        <label for="authorBio" class="form-label fw-medium">Author Bio</label>
                        <textarea class="form-control" id="authorBio" name="authorBio" rows="3" placeholder="Brief bio about the author..."></textarea>
                    </div>
                    
                    <!-- Landing Page Fields -->
                    <div class="col-12 website-type-fields" data-type="landing" style="display: none;">
                        <label for="landingDescription" class="form-label fw-medium">Product/Service Description</label>
                        <textarea class="form-control" id="landingDescription" name="landingDescription" rows="4" placeholder="Describe your product or service..."></textarea>
                    </div>
                    
                    <div class="col-md-6 website-type-fields" data-type="landing" style="display: none;">
                        <label for="ctaText" class="form-label fw-medium">Call-to-Action Text</label>
                        <input type="text" class="form-control" id="ctaText" name="ctaText" placeholder="Get Started Now">
                    </div>
                    
                    <div class="col-md-6 website-type-fields" data-type="landing" style="display: none;">
                        <label for="ctaUrl" class="form-label fw-medium">Call-to-Action URL</label>
                        <input type="url" class="form-control" id="ctaUrl" name="ctaUrl" placeholder="https://example.com/signup">
                    </div>
                    
                    <!-- Projects/Services/Content Section -->
                    <div class="col-12 mt-4">
                        <h6 class="fw-bold text-dark mb-3">
                            <span class="website-type-fields" data-type="portfolio">Projects</span>
                            <span class="website-type-fields" data-type="business" style="display: none;">Services & Portfolio</span>
                            <span class="website-type-fields" data-type="blog" style="display: none;">Content & Topics</span>
                            <span class="website-type-fields" data-type="landing" style="display: none;">Features & Benefits</span>
                        </h6>
                    </div>
                    
                    <div class="col-12 website-type-fields" data-type="portfolio">
                        <label for="projects" class="form-label fw-medium">Projects Description</label>
                        <textarea class="form-control" id="projects" name="projects" rows="3" placeholder="Describe your key projects..."></textarea>
                    </div>
                    
                    <div class="col-12 website-type-fields" data-type="business" style="display: none;">
                        <label for="businessProjects" class="form-label fw-medium">Services & Case Studies</label>
                        <textarea class="form-control" id="businessProjects" name="businessProjects" rows="3" placeholder="Describe your services and successful case studies..."></textarea>
                    </div>
                    
                    <div class="col-12 website-type-fields" data-type="blog" style="display: none;">
                        <label for="blogTopics" class="form-label fw-medium">Main Blog Topics</label>
                        <textarea class="form-control" id="blogTopics" name="blogTopics" rows="3" placeholder="Describe the main topics you'll write about..."></textarea>
                    </div>
                    
                    <div class="col-12 website-type-fields" data-type="landing" style="display: none;">
                        <label for="landingFeatures" class="form-label fw-medium">Key Features & Benefits</label>
                        <textarea class="form-control" id="landingFeatures" name="landingFeatures" rows="3" placeholder="List the key features and benefits of your product/service..."></textarea>
                    </div>
                    
                    <!-- Social Links -->
                    <div class="col-12 mt-4">
                        <h6 class="fw-bold text-dark mb-3">Social Links</h6>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="linkedin" class="form-label fw-medium">LinkedIn</label>
                        <input type="url" class="form-control" id="linkedin" name="linkedin" placeholder="https://linkedin.com/in/username">
                    </div>
                    
                    <div class="col-md-6">
                        <label for="github" class="form-label fw-medium">GitHub</label>
                        <input type="url" class="form-control" id="github" name="github" placeholder="https://github.com/username">
                    </div>
                    
                    <div class="col-md-6">
                        <label for="twitter" class="form-label fw-medium">Twitter</label>
                        <input type="url" class="form-control" id="twitter" name="twitter" placeholder="https://twitter.com/username">
                    </div>
                    
                    <div class="col-md-6">
                        <label for="instagram" class="form-label fw-medium">Instagram</label>
                        <input type="url" class="form-control" id="instagram" name="instagram" placeholder="https://instagram.com/username">
                    </div>
                    
                    <!-- Design Preferences -->
                    <div class="col-12 mt-4">
                        <h6 class="fw-bold text-dark mb-3">Design Preferences</h6>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="colorScheme" class="form-label fw-medium">Color Scheme</label>
                        <select class="form-select" id="colorScheme" name="colorScheme">
                            <option value="modern">Modern (Blue & White)</option>
                            <option value="dark">Dark Theme</option>
                            <option value="minimal">Minimal (Black & White)</option>
                            <option value="colorful">Colorful</option>
                            <option value="professional">Professional (Navy & Gray)</option>
                            <option value="creative">Creative (Purple & Pink)</option>
                        </select>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="layout" class="form-label fw-medium">Layout Style</label>
                        <select class="form-select" id="layout" name="layout">
                            <option value="modern">Modern</option>
                            <option value="classic">Classic</option>
                            <option value="creative">Creative</option>
                            <option value="minimal">Minimal</option>
                        </select>
                    </div>
                    
                    <!-- Technology Stack -->
                    <div class="col-12 mt-4">
                        <h6 class="fw-bold text-dark mb-3">Technology Stack</h6>
                    </div>
                    
                    <div class="col-12">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="techStackPHP" name="techStack" value="php-tailwind" checked>
                                    <label class="form-check-label" for="techStackPHP">
                                        <strong>PHP + Tailwind CSS</strong> <span class="badge bg-primary ms-2">Default</span>
                                        <br><small class="text-muted">Dynamic PHP pages with modern Tailwind styling</small>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="techStackHTML" name="techStack" value="html-bootstrap">
                                    <label class="form-check-label" for="techStackHTML">
                                        <strong>HTML + Bootstrap + CSS + JS</strong>
                                        <br><small class="text-muted">Static HTML pages with Bootstrap framework</small>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Pages to Include -->
                    <div class="col-12 mt-4">
                        <h6 class="fw-bold text-dark mb-3">Pages to Include</h6>
                    </div>
                    
                    <div class="col-12" id="pagesContainer">
                        <!-- Portfolio Pages -->
                        <div class="row g-2 website-type-pages" data-type="portfolio">
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="pageHome" name="pages[]" value="home" checked>
                                    <label class="form-check-label" for="pageHome">Home</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="pageAbout" name="pages[]" value="about" checked>
                                    <label class="form-check-label" for="pageAbout">About</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="pageProjects" name="pages[]" value="projects" checked>
                                    <label class="form-check-label" for="pageProjects">Projects</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="pageContact" name="pages[]" value="contact" checked>
                                    <label class="form-check-label" for="pageContact">Contact</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="pageGallery" name="pages[]" value="gallery">
                                    <label class="form-check-label" for="pageGallery">Gallery</label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Business Pages -->
                        <div class="row g-2 website-type-pages" data-type="business" style="display: none;">
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="pageHomeB" name="pages[]" value="home" checked>
                                    <label class="form-check-label" for="pageHomeB">Home</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="pageAboutB" name="pages[]" value="about" checked>
                                    <label class="form-check-label" for="pageAboutB">About Us</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="pageServicesB" name="pages[]" value="services" checked>
                                    <label class="form-check-label" for="pageServicesB">Services</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="pageContactB" name="pages[]" value="contact" checked>
                                    <label class="form-check-label" for="pageContactB">Contact</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="pageTeamB" name="pages[]" value="team">
                                    <label class="form-check-label" for="pageTeamB">Team</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="pagePortfolioB" name="pages[]" value="portfolio">
                                    <label class="form-check-label" for="pagePortfolioB">Portfolio</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="pageBlogB" name="pages[]" value="blog">
                                    <label class="form-check-label" for="pageBlogB">Blog</label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Blog Pages -->
                        <div class="row g-2 website-type-pages" data-type="blog" style="display: none;">
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="pageHomeBlog" name="pages[]" value="home" checked>
                                    <label class="form-check-label" for="pageHomeBlog">Home</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="pageAboutBlog" name="pages[]" value="about" checked>
                                    <label class="form-check-label" for="pageAboutBlog">About</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="pageBlogMain" name="pages[]" value="blog" checked>
                                    <label class="form-check-label" for="pageBlogMain">Blog</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="pageContactBlog" name="pages[]" value="contact" checked>
                                    <label class="form-check-label" for="pageContactBlog">Contact</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="pageCategoriesBlog" name="pages[]" value="categories">
                                    <label class="form-check-label" for="pageCategoriesBlog">Categories</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="pageArchiveBlog" name="pages[]" value="archive">
                                    <label class="form-check-label" for="pageArchiveBlog">Archive</label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Landing Page Pages -->
                        <div class="row g-2 website-type-pages" data-type="landing" style="display: none;">
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="pageHomeLanding" name="pages[]" value="home" checked>
                                    <label class="form-check-label" for="pageHomeLanding">Landing Page</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="pageAboutLanding" name="pages[]" value="about">
                                    <label class="form-check-label" for="pageAboutLanding">About</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="pageContactLanding" name="pages[]" value="contact">
                                    <label class="form-check-label" for="pageContactLanding">Contact</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Generate Button -->
                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-success btn-lg px-4" id="generateBtn">
                            <i class="fas fa-magic me-2"></i>
                            Generate Website
                        </button>
                    </div>
                </div>
            </form>
            </div>
        </div>

        <!-- Progress Section -->
        <div class="tool-card mb-4" id="progressSection" style="display: none;">
            <div class="tool-card-header">
                <h5 class="mb-0 d-flex align-items-center gap-2">
                    <i class="fas fa-cogs text-primary"></i>
                    Generation Progress
                </h5>
            </div>
            <div class="tool-card-body">
            
            <div class="progress mb-3" style="height: 8px;">
                <div class="progress-bar bg-success" role="progressbar" style="width: 0%" id="progressBar"></div>
            </div>
            
            <div id="progressText" class="text-muted">
                Initializing website generation...
            </div>
            
            <div id="progressSteps" class="mt-3">
                <!-- Progress steps will be added dynamically -->
            </div>
            </div>
        </div>

        <!-- Results Section -->
        <div class="tool-card" id="resultsSection" style="display: none;">
            <div class="tool-card-header">
                <h5 class="mb-0 d-flex align-items-center gap-2">
                    <i class="fas fa-check-circle text-success"></i>
                    Website Generated Successfully!
                </h5>
            </div>
            <div class="tool-card-body">
            
            <div class="row g-3">
                <div class="col-md-6">
                    <button class="btn btn-primary btn-lg w-100" id="previewBtn">
                        <i class="fas fa-eye me-2"></i>
                        Preview Website
                    </button>
                </div>
                <div class="col-md-6">
                    <button class="btn btn-success btn-lg w-100" id="downloadBtn">
                        <i class="fas fa-download me-2"></i>
                        Download ZIP
                    </button>
                </div>
            </div>
            
            <div class="mt-4" id="websiteInfo">
                <!-- Website info will be populated here -->
            </div>
            </div>
        </div>
    </div>
</div>

<style>
.content-card {
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border-radius: 0.5rem;
}

.icon-box {
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    width: 50px;
    height: 50px;
}

.form-label {
    color: #495057;
    margin-bottom: 0.5rem;
}

.form-control, .form-select {
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
    padding: 0.75rem;
}

.form-control:focus, .form-select:focus {
    border-color: #28a745;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
}

.btn-success {
    background-color: #28a745;
    border-color: #28a745;
}

.btn-success:hover {
    background-color: #218838;
    border-color: #1e7e34;
}

.progress-step {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 0;
    border-bottom: 1px solid #f8f9fa;
}

.progress-step:last-child {
    border-bottom: none;
}

.progress-step .step-icon {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
}

.progress-step.completed .step-icon {
    background-color: #28a745;
    color: white;
}

.progress-step.active .step-icon {
    background-color: #007bff;
    color: white;
}

.progress-step.pending .step-icon {
    background-color: #6c757d;
    color: white;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('webGenForm');
    const progressSection = document.getElementById('progressSection');
    const resultsSection = document.getElementById('resultsSection');
    const progressBar = document.getElementById('progressBar');
    const progressText = document.getElementById('progressText');
    const progressSteps = document.getElementById('progressSteps');
    const websiteTypeSelect = document.getElementById('websiteType');
    
    let currentWebsiteId = null;
    
    // Handle website type change
    websiteTypeSelect.addEventListener('change', function() {
        const selectedType = this.value;
        
        // Hide all type-specific fields
        document.querySelectorAll('.website-type-fields').forEach(field => {
            field.style.display = 'none';
            // Disable inputs in hidden fields
            field.querySelectorAll('input, textarea, select').forEach(input => {
                input.disabled = true;
            });
        });
        
        // Hide all type-specific pages
        document.querySelectorAll('.website-type-pages').forEach(pageGroup => {
            pageGroup.style.display = 'none';
            // Uncheck and disable checkboxes in hidden page groups
            pageGroup.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
                checkbox.checked = false;
                checkbox.disabled = true;
            });
        });
        
        if (selectedType) {
            // Show fields for selected type
            document.querySelectorAll(`[data-type="${selectedType}"]`).forEach(field => {
                field.style.display = field.classList.contains('website-type-pages') ? 'flex' : 'block';
                // Enable inputs in visible fields
                field.querySelectorAll('input, textarea, select').forEach(input => {
                    input.disabled = false;
                });
            });
            
            // Check default pages for the selected type
            const defaultPages = getDefaultPagesForType(selectedType);
            defaultPages.forEach(pageName => {
                const checkbox = document.querySelector(`[data-type="${selectedType}"] input[value="${pageName}"]`);
                if (checkbox) {
                    checkbox.checked = true;
                }
            });
        }
    });
    
    function getDefaultPagesForType(type) {
        switch(type) {
            case 'portfolio':
                return ['home', 'about', 'projects', 'contact'];
            case 'business':
                return ['home', 'about', 'services', 'contact'];
            case 'blog':
                return ['home', 'about', 'blog', 'contact'];
            case 'landing':
                return ['home'];
            default:
                return ['home', 'about', 'contact'];
        }
    }
    
    // Initialize with portfolio type (default)
    websiteTypeSelect.dispatchEvent(new Event('change'));
    
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        // Show progress section
        progressSection.style.display = 'block';
        resultsSection.style.display = 'none';
        
        // Scroll to progress section
        progressSection.scrollIntoView({ behavior: 'smooth' });
        
        // Collect form data
        const formData = new FormData(form);
        const data = {};
        
        // Convert FormData to regular object
        for (let [key, value] of formData.entries()) {
            if (key === 'pages[]') {
                if (!data.pages) data.pages = [];
                data.pages.push(value);
            } else {
                data[key] = value;
            }
        }
        
        try {
            await generateWebsite(data);
        } catch (error) {
            console.error('Website generation failed:', error);
            showError('Website generation failed. Please try again.');
        }
    });
    
    async function generateWebsite(data) {
        const steps = [
            'Creating folder structure...',
            'Generating header and footer...',
            'Creating individual pages...',
            'Finalizing website...'
        ];
        
        updateProgress(0, 'Starting website generation...');
        createProgressSteps(steps);
        
        try {
            // Step 1: Generate folder structure and common files
            updateProgress(25, 'Creating folder structure and common files...');
            updateStepStatus(0, 'active');
            
            const structureResponse = await fetch('generate_website_structure.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data)
            });
            
            const structureResult = await structureResponse.json();
            
            if (!structureResult.success) {
                throw new Error(structureResult.error || 'Failed to create website structure');
            }
            
            currentWebsiteId = structureResult.websiteId;
            updateStepStatus(0, 'completed');
            
            // Step 2: Generate individual pages
            updateProgress(50, 'Generating individual pages...');
            updateStepStatus(1, 'completed');
            updateStepStatus(2, 'active');
            
            const pages = data.pages || ['home', 'about', 'projects', 'contact'];
            
            for (let i = 0; i < pages.length; i++) {
                const pageResponse = await fetch('generate_website_page.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        ...data,
                        websiteId: currentWebsiteId,
                        pageName: pages[i],
                        folderStructure: structureResult.folderStructure,
                        headerContent: structureResult.headerContent,
                        footerContent: structureResult.footerContent
                    })
                });
                
                const pageResult = await pageResponse.json();
                
                if (!pageResult.success) {
                    throw new Error(`Failed to generate ${pages[i]} page: ${pageResult.error}`);
                }
                
                const pageProgress = 50 + ((i + 1) / pages.length) * 40;
                updateProgress(pageProgress, `Generated ${pages[i]} page...`);
            }
            
            updateStepStatus(2, 'completed');
            
            // Step 3: Finalize
            updateProgress(100, 'Website generated successfully!');
            updateStepStatus(3, 'completed');
            
            // Show results
            setTimeout(() => {
                showResults(currentWebsiteId, data.websiteName);
            }, 1000);
            
        } catch (error) {
            console.error('Generation error:', error);
            showError(error.message);
        }
    }
    
    function updateProgress(percent, text) {
        progressBar.style.width = percent + '%';
        progressText.textContent = text;
    }
    
    function createProgressSteps(steps) {
        progressSteps.innerHTML = '';
        steps.forEach((step, index) => {
            const stepElement = document.createElement('div');
            stepElement.className = 'progress-step pending';
            stepElement.innerHTML = `
                <div class="step-icon">${index + 1}</div>
                <div class="step-text">${step}</div>
            `;
            progressSteps.appendChild(stepElement);
        });
    }
    
    function updateStepStatus(stepIndex, status) {
        const steps = progressSteps.querySelectorAll('.progress-step');
        if (steps[stepIndex]) {
            steps[stepIndex].className = `progress-step ${status}`;
            if (status === 'completed') {
                steps[stepIndex].querySelector('.step-icon').innerHTML = '<i class="fas fa-check"></i>';
            }
        }
    }
    
    function showResults(websiteId, websiteName) {
        resultsSection.style.display = 'block';
        resultsSection.scrollIntoView({ behavior: 'smooth' });
        
        document.getElementById('websiteInfo').innerHTML = `
            <div class="alert alert-success">
                <h6 class="fw-bold mb-2">Website: ${websiteName}</h6>
                <p class="mb-0">Your website has been generated successfully! You can now preview it or download the complete files.</p>
            </div>
        `;
        
        // Setup preview and download buttons
        document.getElementById('previewBtn').onclick = () => {
            window.open(`generated_websites/${websiteId}/`, '_blank');
        };
        
        document.getElementById('downloadBtn').onclick = () => {
            window.location.href = `download_website.php?id=${websiteId}`;
        };
    }
    
    function showError(message) {
        progressText.innerHTML = `<span class="text-danger"><i class="fas fa-exclamation-triangle me-2"></i>${message}</span>`;
        progressBar.classList.add('bg-danger');
    }
});
</script>

<style>
.feature-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: all 0.3s ease;
}

.feature-icon:hover {
    transform: scale(1.1);
}

.step-card {
    transition: all 0.3s ease;
    cursor: pointer;
}

.step-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1) !important;
}

.step-card:hover .feature-icon {
    transform: scale(1.15);
}

.step-card:hover .bg-primary.bg-opacity-10 {
    background-color: rgba(13, 110, 253, 0.2) !important;
}

.step-card:hover .bg-success.bg-opacity-10 {
    background-color: rgba(25, 135, 84, 0.2) !important;
}

.step-card:hover .bg-warning.bg-opacity-10 {
    background-color: rgba(255, 193, 7, 0.2) !important;
}

.step-card:hover .bg-info.bg-opacity-10 {
    background-color: rgba(13, 202, 240, 0.2) !important;
}

/* Add subtle animation */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.step-card {
    animation: fadeInUp 0.6s ease forwards;
}

.step-card:nth-child(1) { animation-delay: 0.1s; }
.step-card:nth-child(2) { animation-delay: 0.2s; }
.step-card:nth-child(3) { animation-delay: 0.3s; }
.step-card:nth-child(4) { animation-delay: 0.4s; }

/* Responsive improvements */
@media (max-width: 768px) {
    .step-card {
        margin-bottom: 2rem;
    }
    
    .feature-icon {
        width: 60px !important;
        height: 60px !important;
    }
    
    .feature-icon i {
        font-size: 1.5rem !important;
    }
    
    .position-absolute.top-0.start-50.translate-middle div {
        width: 25px !important;
        height: 25px !important;
        font-size: 12px !important;
    }
}
</style>
