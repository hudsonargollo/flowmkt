# Design Document: Pricing Plans Configuration and Display

## Overview

This design specifies the implementation of a pricing plans configuration system and user interface for displaying three subscription tiers: Starter (Projects), Pro (Growth), and Business (Scale). The system provides structured plan data and a responsive UI component for presenting plan options to prospective customers.

The design focuses on:
- Defining plan configurations as structured data
- Creating a reusable plan display component
- Implementing billing cycle toggle functionality
- Ensuring responsive design across devices
- Providing an API for plan data access

## Architecture

The system follows a layered architecture:

```
┌─────────────────────────────────────────┐
│         Presentation Layer              │
│  (Plan Display Component, UI Controls)  │
└─────────────────┬───────────────────────┘
                  │
┌─────────────────▼───────────────────────┐
│         Application Layer               │
│  (Plan Service, Configuration Manager)  │
└─────────────────┬───────────────────────┘
                  │
┌─────────────────▼───────────────────────┐
│           Data Layer                    │
│     (Plan Configurations, Constants)    │
└─────────────────────────────────────────┘
```

**Key Architectural Decisions:**

1. **Static Configuration**: Plan data is defined as static configuration rather than database records, as plans change infrequently and need to be version-controlled
2. **Component-Based UI**: The plan display is implemented as a reusable component that can be embedded in multiple pages
3. **Separation of Concerns**: Plan data, business logic, and presentation are clearly separated
4. **API-First**: Plan data is accessible via API for use throughout the application

## Components and Interfaces

### 1. Plan Configuration Data Structure

**Purpose**: Define the structure for storing plan information

**Interface**:
```typescript
interface PlanConfiguration {
  id: string;                    // 'starter' | 'pro' | 'business'
  name: string;                  // Display name: 'Projects' | 'Growth' | 'Scale'
  monthlyPrice: number;          // Price in BRL cents (e.g., 9700 for R$ 97)
  annualPrice: number;           // Price in BRL cents (e.g., 97000 for R$ 970)
  features: PlanFeatures;
  highlighted?: boolean;         // Whether to highlight this plan (e.g., "Most Popular")
}

interface PlanFeatures {
  instances: number | null;      // null represents unlimited
  contacts: number | null;
  automationFlows: number | null;
  agents: number | null;
  aiCapability: string;
  supportLevel: string;
}
```

**Implementation Notes**:
- Prices stored in cents to avoid floating-point precision issues
- `null` used to represent unlimited features
- Plan IDs are lowercase for consistency with database/API conventions
- Display names are user-facing labels

### 2. Plan Service

**Purpose**: Provide access to plan configurations and related operations

**Interface**:
```typescript
class PlanService {
  // Retrieve all plan configurations
  getAllPlans(): PlanConfiguration[]
  
  // Retrieve a specific plan by ID
  getPlanById(planId: string): PlanConfiguration | null
  
  // Calculate monthly equivalent for annual pricing
  getMonthlyEquivalent(annualPrice: number): number
  
  // Calculate savings for annual billing
  getAnnualSavings(monthlyPrice: number, annualPrice: number): {
    amount: number;
    percentage: number;
  }
  
  // Format price for display
  formatPrice(priceInCents: number): string
  
  // Check if a feature is unlimited
  isUnlimited(featureValue: number | null): boolean
}
```

**Responsibilities**:
- Centralize access to plan data
- Provide utility functions for price calculations
- Handle price formatting with proper currency symbols
- Abstract plan data structure from consumers

### 3. Plan Display Component

**Purpose**: Render the pricing plans UI with all three tiers

**Props Interface**:
```typescript
interface PlanDisplayProps {
  currentPlanId?: string;        // User's current plan (if subscribed)
  onPlanSelect: (planId: string, billingCycle: 'monthly' | 'annual') => void;
  defaultBillingCycle?: 'monthly' | 'annual';
  showComparison?: boolean;      // Whether to show detailed feature comparison
}
```

**Component Structure**:
```
PlanDisplay
├── BillingCycleToggle
├── PlanCard (x3)
│   ├── PlanHeader
│   ├── PricingDisplay
│   ├── FeatureList
│   └── SelectButton
└── FeatureComparisonTable (optional)
```

**State Management**:
```typescript
interface PlanDisplayState {
  selectedBillingCycle: 'monthly' | 'annual';
  plans: PlanConfiguration[];
}
```

### 4. Billing Cycle Toggle Component

**Purpose**: Allow users to switch between monthly and annual pricing views

**Props Interface**:
```typescript
interface BillingCycleToggleProps {
  value: 'monthly' | 'annual';
  onChange: (cycle: 'monthly' | 'annual') => void;
  showSavings?: boolean;         // Whether to show "Save 2 months" label
}
```

**Visual Design**:
- Toggle switch or segmented control
- Clear labels for "Monthly" and "Annual"
- Optional savings badge on annual option

### 5. Plan Card Component

**Purpose**: Display a single plan tier with its features and pricing

**Props Interface**:
```typescript
interface PlanCardProps {
  plan: PlanConfiguration;
  billingCycle: 'monthly' | 'annual';
  isCurrentPlan?: boolean;
  isHighlighted?: boolean;
  onSelect: () => void;
}
```

**Layout**:
1. Plan name and optional badge (e.g., "Most Popular")
2. Price display with billing cycle
3. Feature list with icons/checkmarks
4. Call-to-action button

### 6. Feature List Component

**Purpose**: Display plan features with appropriate formatting

**Props Interface**:
```typescript
interface FeatureListProps {
  features: PlanFeatures;
  compact?: boolean;             // Compact vs. detailed view
}
```

**Rendering Rules**:
- Numeric limits: Format with thousand separators (e.g., "1,000")
- Unlimited features: Display "Unlimited" or ∞ symbol
- Text features: Display as-is (e.g., "Basic AI Assistant (Keywords)")
- Use consistent icons for each feature type

## Data Models

### Plan Configurations Constant

The three plan configurations are defined as a constant array:

```typescript
export const PLAN_CONFIGURATIONS: PlanConfiguration[] = [
  {
    id: 'starter',
    name: 'Projects',
    monthlyPrice: 9700,      // R$ 97.00
    annualPrice: 97000,      // R$ 970.00
    features: {
      instances: 1,
      contacts: 1000,
      automationFlows: 5,
      agents: 2,
      aiCapability: 'Basic AI Assistant (Keywords)',
      supportLevel: 'Support via Ticket'
    }
  },
  {
    id: 'pro',
    name: 'Growth',
    monthlyPrice: 24700,     // R$ 247.00
    annualPrice: 247000,     // R$ 2,470.00
    features: {
      instances: 3,
      contacts: 5000,
      automationFlows: 20,
      agents: 10,
      aiCapability: 'Advanced AI (LLM)',
      supportLevel: 'Priority Support'
    },
    highlighted: true        // Mark as "Most Popular"
  },
  {
    id: 'business',
    name: 'Scale',
    monthlyPrice: 49700,     // R$ 497.00
    annualPrice: 497000,     // R$ 4,970.00
    features: {
      instances: 10,         // Minimum, can be expanded
      contacts: null,        // Unlimited
      automationFlows: null, // Unlimited
      agents: null,          // Unlimited
      aiCapability: 'Customized AI / RAG',
      supportLevel: 'Account Manager'
    }
  }
];
```

### Feature Display Configuration

Define how each feature should be displayed:

```typescript
interface FeatureDisplayConfig {
  key: keyof PlanFeatures;
  label: string;
  icon?: string;
  formatValue: (value: number | string | null) => string;
}

export const FEATURE_DISPLAY_CONFIG: FeatureDisplayConfig[] = [
  {
    key: 'instances',
    label: 'Instances (Accounts)',
    icon: 'server',
    formatValue: (v) => v === null ? 'Unlimited' : `Up to ${v}`
  },
  {
    key: 'contacts',
    label: 'Contacts',
    icon: 'users',
    formatValue: (v) => v === null ? 'Unlimited' : `Up to ${v.toLocaleString()}`
  },
  {
    key: 'automationFlows',
    label: 'Automation Flows',
    icon: 'workflow',
    formatValue: (v) => v === null ? 'Unlimited' : `${v} Flows`
  },
  {
    key: 'agents',
    label: 'Agents (Humans)',
    icon: 'user-check',
    formatValue: (v) => v === null ? 'Unlimited' : `${v} Agents`
  },
  {
    key: 'aiCapability',
    label: 'AI Assistant',
    icon: 'brain',
    formatValue: (v) => String(v)
  },
  {
    key: 'supportLevel',
    label: 'Support',
    icon: 'help-circle',
    formatValue: (v) => String(v)
  }
];
```

## Correctness Properties

*A property is a characteristic or behavior that should hold true across all valid executions of a system—essentially, a formal statement about what the system should do. Properties serve as the bridge between human-readable specifications and machine-verifiable correctness guarantees.*


### Property 1: Plan Configuration Completeness

*For any* plan configuration retrieved from the system, it must contain all required fields: id, name, monthlyPrice, annualPrice, and a features object with instances, contacts, automationFlows, agents, aiCapability, and supportLevel.

**Validates: Requirements 1.2, 1.3, 10.3**

### Property 2: Plan Retrieval by ID

*For any* valid plan ID ('starter', 'pro', 'business'), calling getPlanById with that ID should return a plan configuration with matching ID.

**Validates: Requirements 10.2**

### Property 3: Plan Data Consistency

*For any* plan configuration, retrieving it multiple times should return equivalent data (same values for all fields).

**Validates: Requirements 10.5**

### Property 4: Rendered Plans Contain Configuration Data

*For any* plan configuration, when rendered by the Plan Display component, the output should contain the plan's display name and all feature values from the configuration.

**Validates: Requirements 5.2, 5.4, 8.2**

### Property 5: Displayed Prices Match Selected Billing Cycle

*For any* plan and billing cycle selection, the displayed price should match the plan's monthly price when cycle is 'monthly', and the annual price when cycle is 'annual'.

**Validates: Requirements 6.2, 6.3**

### Property 6: Annual Savings Calculation

*For any* plan with annual billing selected, the displayed savings should equal (monthlyPrice × 12) - annualPrice, which represents 2 months free.

**Validates: Requirements 5.6, 6.4**

### Property 7: Feature Value Formatting

*For any* feature value, when displayed: numeric values should include thousand separators, null values should display as "Unlimited" or ∞, and string values should display as-is.

**Validates: Requirements 8.3, 8.4**

### Property 8: Feature Display Order Consistency

*For any* two plans rendered in the same display, the features should appear in the same order.

**Validates: Requirements 8.1**

### Property 9: Plan Selection Callback

*For any* plan card, when the selection button is clicked, the onPlanSelect callback should be invoked with the correct plan ID and current billing cycle.

**Validates: Requirements 7.2, 7.4**

### Property 10: Current Plan Indication

*For any* plan display where currentPlanId prop is provided, the plan card matching that ID should be visually indicated as the current plan.

**Validates: Requirements 7.5**

### Property 11: Selection Button Presence

*For any* rendered plan card, it should contain a selection button or call-to-action element.

**Validates: Requirements 7.1**

### Property 12: Feature List Completeness

*For any* plan configuration, the rendered feature list should include all six feature types: instances, contacts, automation flows, agents, AI capability, and support level.

**Validates: Requirements 5.4**

## Error Handling

### Invalid Plan ID

**Scenario**: User requests a plan that doesn't exist

**Handling**:
- `getPlanById()` returns `null` for invalid plan IDs
- Calling code should check for null and handle gracefully
- UI should display error message or redirect to valid plans page

**Example**:
```typescript
const plan = planService.getPlanById('invalid-plan');
if (!plan) {
  // Handle error: show message or redirect
  return <ErrorMessage>Plan not found</ErrorMessage>;
}
```

### Missing Plan Configuration

**Scenario**: Plan configuration is incomplete or malformed

**Handling**:
- Validate plan configurations at application startup
- Throw error if required fields are missing
- Fail fast to prevent runtime errors

**Example**:
```typescript
function validatePlanConfiguration(plan: PlanConfiguration): void {
  if (!plan.id || !plan.name || plan.monthlyPrice === undefined) {
    throw new Error(`Invalid plan configuration: ${JSON.stringify(plan)}`);
  }
}
```

### Price Formatting Errors

**Scenario**: Price value is negative or invalid

**Handling**:
- Validate price values are non-negative
- Return formatted "R$ 0,00" for invalid values
- Log warning for debugging

**Example**:
```typescript
function formatPrice(priceInCents: number): string {
  if (priceInCents < 0) {
    console.warn(`Invalid price: ${priceInCents}`);
    return 'R$ 0,00';
  }
  return `R$ ${(priceInCents / 100).toFixed(2).replace('.', ',')}`;
}
```

### Component Rendering Errors

**Scenario**: Plan Display component receives invalid props

**Handling**:
- Validate props using TypeScript types
- Provide default values for optional props
- Display error boundary if rendering fails

**Example**:
```typescript
function PlanDisplay({ 
  currentPlanId, 
  onPlanSelect, 
  defaultBillingCycle = 'monthly',
  showComparison = false 
}: PlanDisplayProps) {
  if (!onPlanSelect) {
    throw new Error('onPlanSelect callback is required');
  }
  // ... component logic
}
```

### Callback Errors

**Scenario**: onPlanSelect callback throws an error

**Handling**:
- Wrap callback invocation in try-catch
- Display error message to user
- Log error for debugging
- Prevent UI from breaking

**Example**:
```typescript
function handlePlanSelect(planId: string, billingCycle: BillingCycle) {
  try {
    onPlanSelect(planId, billingCycle);
  } catch (error) {
    console.error('Error selecting plan:', error);
    setError('Failed to select plan. Please try again.');
  }
}
```

## Testing Strategy

### Dual Testing Approach

This feature requires both unit tests and property-based tests for comprehensive coverage:

**Unit Tests** focus on:
- Specific plan configuration values (Starter plan has R$ 97 monthly price)
- Component rendering with specific props
- Edge cases (invalid plan IDs, missing props)
- Error handling scenarios
- User interaction flows (clicking buttons, toggling billing cycle)

**Property-Based Tests** focus on:
- Universal properties that hold for all plans
- Data structure completeness across all configurations
- Formatting consistency across all numeric values
- Callback behavior for any plan selection
- Display consistency across all billing cycles

Together, these approaches ensure both concrete correctness (specific values are right) and general correctness (system behaves correctly for all inputs).

### Property-Based Testing Configuration

**Library Selection**: Use `fast-check` for TypeScript/JavaScript property-based testing

**Test Configuration**:
- Minimum 100 iterations per property test
- Each test tagged with feature name and property number
- Tag format: `Feature: pricing-plans-system, Property {N}: {property description}`

**Example Property Test Structure**:
```typescript
import fc from 'fast-check';

describe('Feature: pricing-plans-system, Property 1: Plan Configuration Completeness', () => {
  it('should have all required fields for any plan', () => {
    fc.assert(
      fc.property(
        fc.constantFrom('starter', 'pro', 'business'),
        (planId) => {
          const plan = planService.getPlanById(planId);
          expect(plan).toBeDefined();
          expect(plan).toHaveProperty('id');
          expect(plan).toHaveProperty('name');
          expect(plan).toHaveProperty('monthlyPrice');
          expect(plan).toHaveProperty('annualPrice');
          expect(plan).toHaveProperty('features');
          expect(plan.features).toHaveProperty('instances');
          expect(plan.features).toHaveProperty('contacts');
          expect(plan.features).toHaveProperty('automationFlows');
          expect(plan.features).toHaveProperty('agents');
          expect(plan.features).toHaveProperty('aiCapability');
          expect(plan.features).toHaveProperty('supportLevel');
        }
      ),
      { numRuns: 100 }
    );
  });
});
```

### Unit Test Examples

**Plan Configuration Tests**:
```typescript
describe('Plan Configurations', () => {
  it('should have exactly three plans', () => {
    const plans = planService.getAllPlans();
    expect(plans).toHaveLength(3);
  });

  it('should configure Starter plan correctly', () => {
    const starter = planService.getPlanById('starter');
    expect(starter.name).toBe('Projects');
    expect(starter.monthlyPrice).toBe(9700);
    expect(starter.annualPrice).toBe(97000);
    expect(starter.features.instances).toBe(1);
    expect(starter.features.contacts).toBe(1000);
    expect(starter.features.automationFlows).toBe(5);
    expect(starter.features.agents).toBe(2);
    expect(starter.features.aiCapability).toBe('Basic AI Assistant (Keywords)');
    expect(starter.features.supportLevel).toBe('Support via Ticket');
  });

  it('should configure Business plan with unlimited features', () => {
    const business = planService.getPlanById('business');
    expect(business.features.contacts).toBeNull();
    expect(business.features.automationFlows).toBeNull();
    expect(business.features.agents).toBeNull();
  });
});
```

**Component Tests**:
```typescript
describe('PlanDisplay Component', () => {
  it('should render all three plans', () => {
    const { container } = render(
      <PlanDisplay onPlanSelect={jest.fn()} />
    );
    expect(container.querySelectorAll('.plan-card')).toHaveLength(3);
  });

  it('should show monthly prices by default', () => {
    const { getByText } = render(
      <PlanDisplay onPlanSelect={jest.fn()} />
    );
    expect(getByText('R$ 97')).toBeInTheDocument();
    expect(getByText('R$ 247')).toBeInTheDocument();
    expect(getByText('R$ 497')).toBeInTheDocument();
  });

  it('should call onPlanSelect when plan is selected', () => {
    const onPlanSelect = jest.fn();
    const { getByText } = render(
      <PlanDisplay onPlanSelect={onPlanSelect} />
    );
    
    fireEvent.click(getByText('Select Plan'));
    expect(onPlanSelect).toHaveBeenCalledWith('starter', 'monthly');
  });
});
```

### Integration Testing

**End-to-End Flow**:
1. User views pricing page
2. User toggles between monthly and annual billing
3. User selects a plan
4. System navigates to checkout with correct plan data

**Test Approach**:
- Use Cypress or Playwright for E2E tests
- Mock subscription system API
- Verify correct data passed to checkout
- Test responsive behavior on different viewports

### Visual Regression Testing

**Purpose**: Ensure UI remains consistent across changes

**Approach**:
- Use Chromatic or Percy for visual snapshots
- Capture screenshots of plan display in different states
- Compare against baseline images
- Flag visual changes for review

**Test Cases**:
- Default view (monthly billing)
- Annual billing view
- Current plan highlighted
- Mobile responsive view
- Tablet responsive view
- Desktop view
