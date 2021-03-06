<?php
namespace Victoire\Bundle\WidgetBundle\Renderer;

use Symfony\Component\DependencyInjection\Container;
use Victoire\Bundle\BusinessEntityPageBundle\Entity\BusinessEntityPage;
use Victoire\Bundle\CoreBundle\Entity\View;
use Victoire\Bundle\CoreBundle\Event\WidgetRenderEvent;
use Victoire\Bundle\CoreBundle\VictoireCmsEvents;
use Victoire\Bundle\WidgetBundle\Model\Widget;

class WidgetRenderer
{
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * render the Widget
     * @param Widget $widget
     * @param View   $view
     *
     * @return widget show
     */
    public function render(Widget $widget, View $view)
    {
        //the mode of display of the widget
        $mode = $widget->getMode();

        //if entty is given and it's not the object, retrive it and set the entity for the widget
        if ($mode == Widget::MODE_BUSINESS_ENTITY && $view instanceof BusinessEntityPage) {
            $widget->setEntity($view->getBusinessEntity());
        }

        //the templating service
        $templating = $this->container->get('victoire_templating');

        //the content of the widget
        $parameters = $this->container->get('victoire_widget.widget_content_resolver')->getWidgetContent($widget);

        //the template displayed is in the widget bundle (with the potential theme)
        $showView = 'show'.ucfirst($widget->getTheme());
        $templateName = $this->container->get('victoire_widget.widget_helper')->getTemplateName($showView, $widget);

        return $templating->render(
            $templateName,
            $parameters
        );
    }

    /**
     * render a widget
     * @param Widget $widget
     * @param View   $view
     *
     * @return string
     */
    public function renderContainer(Widget $widget, View $view, $position = 0, $slotOptions = array())
    {
        $dispatcher = $this->container->get('event_dispatcher');
        $securityContext = $this->container->get('security.context');

        $dispatcher->dispatch(VictoireCmsEvents::WIDGET_PRE_RENDER, new WidgetRenderEvent($widget));

        $html = $this->render($widget, $view);

        if ($securityContext->isGranted('ROLE_VICTOIRE')) {
            $html .= $this->renderActions($widget->getSlot(), $view, $slotOptions, $position);
        }

        $html = '<a class="vic-anchor" id="vic-widget-'.$widget->getId().'-container-anchor"></a>'.$html;
        $html = "<div class='vic-widget-container' data-position=\"".($position - 1)."\" data-id=\"".$widget->getId()."\" id='vic-widget-".$widget->getId()."-container'>".$html.'</div>';

        $dispatcher->dispatch(VictoireCmsEvents::WIDGET_POST_RENDER, new WidgetRenderEvent($widget, $html));

        return $html;
    }

    /**
     * render widget actions
     * @param Widget $widget
     *
     * @return template
     */
    public function renderWidgetActions(Widget $widget)
    {
        return $this->container->get('victoire_templating')->render(
            'VictoireCoreBundle:Widget:widgetActions.html.twig',
            array(
                "widget" => $widget,
            )
        );
    }

    /**
     * render widget unlink action
     * @param integer $widgetId
     * @param View    $view
     *
     * @return template
     */
    public function renderUnlinkActionByWidgetId($widgetId, $view)
    {
        return $this->container->get('victoire_templating')->render(
            'VictoireCoreBundle:Widget:widgetUnlinkAction.html.twig',
            array(
                "widgetId" => $widgetId,
                "view" => $view,
            )
        );
    }

    /**
     * render slot actions
     * @param Slot    $slot
     * @param View    $view
     * @param array   $options
     * @param integer $position
     *
     * @return template
     */
    public function renderActions($slot, View $view, $options = array(), $position = 0)
    {
        $slots = $this->container->getParameter('victoire_core.slots');

        $availableWidgets = $this->container->getParameter('victoire_core.widgets');
        $widgets = array();

        //If the slot is declared in config
        if (!empty($slots[$slot]) && !empty($slots[$slot]['widgets'])) {
            //parse declared widgets
            $slotWidgets = array_keys($slots[$slot]['widgets']);
        } elseif (!empty($options['availableWidgets'])) {
            $slotWidgets = $options['availableWidgets'];
        } else {
            //parse all widgets
            $slotWidgets = array_keys($availableWidgets);
        }

        foreach ($slotWidgets as $slotWidget) {
            $widgetParams = $availableWidgets[$slotWidget];
            // if widget has a parent
            if (!empty($widgetParams['parent'])) {
                // place widget under its parent
                $widgets[$widgetParams['parent']]['children'][$slotWidget]['params'] = $widgetParams;
            } else {
                $widgets[$slotWidget]['params'] = $widgetParams;
            }
        }
        $max = null;
        if (!empty($slots[$slot]) && !empty($slots[$slot]['max'])) {
            $max = $slots[$slot]['max'];
        }

        return $this->container->get('victoire_templating')->render(
            "VictoireCoreBundle:Widget:actions.html.twig",
            array(
                "slot"     => $slot,
                "view"     => $view,
                'widgets'  => $widgets,
                'max'      => $max,
                'position' => $position,
            )
        );
    }

    /**
     * Get the extra classes for the css
     *
     * @return string The classes
     */
    public function getExtraCssClass(Widget $widget)
    {
        $cssClass = 'vic-widget-'.strtolower($this->container->get('victoire_widget.widget_helper')->getWidgetName($widget));

        return $cssClass;
    }
}
